<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Models\Branch;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Log;

class TransactionPdfController extends Controller
{
    public function index(User $user){
        $branch = $user->branch ?? Branch::find(1);
        $userProfile = $user->userProfile;
        $invoiceNumber = $user->membershipDetails->invoiceNumber;
        $remainingBalance=Transaction::where('user_id', $user->id)->get()->last()->remaining_amount;
        return view('admin.user.transaction.invoiceView',[
            'user' => $user,
            'transactions' => Transaction::where('user_id', $user->id)->paginate(50),
            'methods' => PaymentMethod::getPaymentMethod(),
            'branch'=>$branch,
            'invoiceNumber'=>$invoiceNumber,
            'userProfile'=>$userProfile,
            'amountPaid'=>Transaction::where('user_id', $user->id)->sum('amount'),
            'remainingBalance'=>$remainingBalance,
            'request' => request()
        ]);
    }
    public function download(User $user){
        try {
            $invoiceNumber = $user->membershipDetails->invoiceNumber;
            $userProfile = $user->userProfile;
            $branch = $user->branch ?? Branch::find(1);
            $transactions= Transaction::where('user_id', $user->id)->paginate(50);
            $methods = PaymentMethod::getPaymentMethod();
            $amountPaid=Transaction::where('user_id', $user->id)->sum('amount');
            $remainingBalance=Transaction::where('user_id', $user->id)->get()->last()->remaining_amount;
            $pdf = Pdf::loadView('admin.pdf.transactionInvoice', compact(
                'invoiceNumber',
                'userProfile',
                'user',
                'branch',
                'transactions',
                'methods',
                'amountPaid',
                'remainingBalance'
            ));
            return $pdf->download('invoice-' . $user->member_id . '.pdf');
        } catch (\Throwable $th) {
            Log::error('Something went wrong unable to create invoice');
        }
    }
    }

