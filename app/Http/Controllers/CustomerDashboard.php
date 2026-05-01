<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerDashboard extends Controller
{
    public function index(): View
    {
        return view('customer.dashboard', [
            'currentPlan' => Auth::user()->lastPayment
        ]);
    }
}
