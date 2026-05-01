<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserMembershipDetail;
use App\Models\UserNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendingRemainingBalanceController extends Controller
{
    public function index()
    {
        return view('admin.remainingbalance.index', [
           'users' => User::remainingBalanceIndexOrderByData(request('orderby'))
                    ->paginate(50)
                    ->withQueryString(),
            'totalRemainingBalance' => UserMembershipDetail::get()->pluck('remaining_amount')->sum(),
            'request' => request(),
        ]);
    }
}
