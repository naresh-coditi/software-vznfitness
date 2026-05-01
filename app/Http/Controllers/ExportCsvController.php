<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportCsvController extends Controller
{
    public function exportCsv()
    {
        $fileName = 'export_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
       
        $callback = function () {
            $file = fopen('php://output', 'w');

            // CSV Header Row
            fputcsv($file, [
                "S.N",
                "Purchase DATE",
                "Name",
                "Role",
                "PHONE NUMBER",
                "GENDER",
                "DOB",
                "M.NO",
                "PACKAGE",
                "START DATE",
                "END DATE",
                "PACKAGE AMOUNT",
                "PAID",
                "Discount",
                "BALANCE",
                "PAYMENT Mode",
                "VALIDITY DAYS",
                "Email"
            ]);

            // Fetching data from multiple related models
            $users = User::with(['userProfile', 'membershipDetails', 'membershipPlans'])
                ->get();

            $serialNumber = 1;

            foreach ($users as $user) {
                $name = $user->userProfile->first_name . ' ' . $user->userProfile->last_name;
                // package
                $package = '';
                if ($user->membershipPlans->isNotEmpty()) {
                    foreach ($user->membershipPlans as $membership) {
                        $package .= '(' . $membership->name . ') + ';
                    }
                    $package = rtrim($package, ' + '); // Remove the trailing ' + '
                } else {
                    $package = 'Null';
                }
                // 

                // payment methods
                $methodCounts = [];
                $transactions = $user->transactions()->get();
                foreach ($transactions as $trans) {
                    if (isset($methodCounts[$trans->method_type])) {
                        $methodCounts[$trans->method_type]++;
                    } else {
                        $methodCounts[$trans->method_type] = 1;
                    }
                }

                if (!empty($methodCounts)) {
                    $method = '';
                    foreach ($methodCounts as $methodType => $count) {
                        $method .= '( ' . $methodType . ' x' . $count . ' ) + ';
                    }
                    $method = rtrim($method, ' + '); // Remove the trailing ' + '
                } else {
                    $method = 'Null';
                }
                // 

                //Validity
                $membershipPlan = MembershipPlan::where('name', $user->membershipDetails->name)->get()->first();
                if ($membershipPlan) {
                    $validity=$membershipPlan->validity;
                } else {
                    $validity = 'Null';
                }
                //
                // Write user data to CSV
                fputcsv($file, [
                    $serialNumber++, // S.N
                    dateformat($user?->membershipDetails?->start_date) ?? 'Null',  // Purchase DATE
                    $name ?? 'Null',  // Name
                    ucfirst(rtrim($user->roleName, '.')) ?? 'Null', // Role
                    optional($user)->phone ?? 'Null',  // PHONE NUMBER
                    optional($user)->userProfile->gender ?? 'Null',  // GENDER
                    'N/A',    // DOB
                    optional($user)->member_id ?? 'Null',      // M.NO (Membership ID)
                    $package ?? 'Null',  // PACKAGE
                    dateformat($user->membershipDetails->start_date) ?? 'Null',    // START DATE
                    dateformat($user->membershipDetails->end_date) ?? 'Null',   // END DATE
                    $user->membershipDetails->amount + $user->membershipDetails->remaining_amount ?? 'Null',  // PACKAGE AMOUNT
                    $user->membershipDetails->amount ?? 'Null',   // PAID
                    'N/A',  // Discount
                    $user->membershipDetails->remaining_amount ?? 'Null',  // BALANCE
                    $method ?? 'Null',  // PAYMENT Mode
                    $validity ?? 'Null',  // VALIDITY DAYS
                    optional($user)->email ?? 'Null' // Email
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
