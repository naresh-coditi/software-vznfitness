<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Log;

class PersonalTrainerPdfController extends Controller
{
    public function __invoke(User $user)
    {
        try {
            $user->load([
                'membershipDetails',
                'latestPersonalTrainerPlan',
                'userProfile',
                'branch'
            ]);

            $invoiceNumber = $user->membershipDetails->invoiceNumber;
            $latestPlan = $user->membershipDetails;
            $userProfile = $user->userProfile;
            $branch = $user->branch ?? Branch::find(1);
            $personalTrainer = $user->latestPersonalTrainerPlan;

            $pdf = Pdf::loadView('admin.pdf.personalTrainerInvoice', compact(
                'invoiceNumber',
                'latestPlan',
                'userProfile',
                'user',
                'branch',
                'personalTrainer'
            ));

            return $pdf->download('invoice-' . $user->member_id . '.pdf');
        } catch (\Throwable $th) {
            Log::error('Something went wrong unable to create invoice');
        }
    }
}
