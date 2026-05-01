<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CancellationOrRefundPolicyController extends Controller
{
    public function view()
    {
        return view('frontend.cancellation&refundpolicy');
    }
}
