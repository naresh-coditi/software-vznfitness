<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionReportController extends Controller
{
    public function index()
    {
        return view('admin.transactionreport.index', [
            'transactions' => Transaction::salesByPaymentMentod(request('method_type'))
                ->dateRange(request('date_range'))
                ->with('createdByProfile', 'userProfile', 'user')
                ->filter(request())
                ->latest()
                ->paginate(50)
                ->withQueryString(),
            'request' => request(),
            'paymentMethods' => PaymentMethod::getPaymentMethod(),
            'totalAmount' => request('method_type') || request('date_range') ? Transaction::salesByPaymentMentod(request('method_type'))->filter(request())->dateRange(request('date_range'))->get()->pluck('amount')->sum() : null
        ]);
    }
}
