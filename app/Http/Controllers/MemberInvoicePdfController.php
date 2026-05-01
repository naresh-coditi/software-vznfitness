<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MemberInvoicePdfController extends Controller
{
    public function __invoke(User $user)
    {
        try {
            $user->load([
                'membershipDetails',
                'userProfile',
                'branch'
            ]);

            $invoiceNumber = $user->membershipDetails->invoiceNumber;
            $latestPlan = $user->membershipDetails;
            $userProfile = $user->userProfile;
            $branch = $user->branch ?? Branch::find(1);

            $pdf = Pdf::loadView('admin.pdf.invoice', compact(
                'invoiceNumber',
                'latestPlan',
                'userProfile',
                'user',
                'branch'
            ));

            return $pdf->download('invoice-' . $user->member_id . '.pdf');
        } catch (\Throwable $th) {
            Log::error('Something went wrong unable to create invioce');
        }
    }
}
