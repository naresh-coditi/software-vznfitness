<?php

namespace App\Http\Controllers;

use App\Enum\MonthNames;
use App\Enum\PaymentMethod;
use App\Enum\UserType;
use App\Models\LeadUser;
use App\Models\MembershipPlan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserMembershipDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $month = $request->month ?? Carbon::now()->format('m');
        $year = $request->year ?? Carbon::now()->format('Y');
        $membershipPlans = MembershipPlan::orderBy('validity')->pluck('name')->toArray();
        $membershipData = [];
        foreach ($membershipPlans as $planName) {
            $userCount = UserMembershipDetail::where('name', $planName)
                ->where('end_date', '>', today())
                ->whereHas('NonDeletedUser', function ($query) {
                    $query->whereNull('deleted_at');
                })
                ->count();
            $membershipData[$planName] = $userCount;
        }
        $totalActiveMembers = User::where('role_id', User::User)->whereHas('membershipDetails', function ($query) {
            $query->where('end_date', '>', today());
        })->count();
        return view('admin.dashboard', [
            'totalStaff' => User::where('role_id', User::Staff)->count(),
            'totalLead' => LeadUser::count(),
            'totalMember' => User::where('role_id', User::User)->count(),
            'ActiveMembers' => $totalActiveMembers,
            'expiringSoon' => UserMembershipDetail::planExpiringsoon()->count(),
            'expired' => UserMembershipDetail::expiredPlan()->count(),
            'monthlySalesData' => Transaction::monthlySales($month, $year),
            'months' => MonthNames::getMonthNames(),
            'minYear' => Transaction::minYear(),
            'maxYear' => Carbon::now()->addYear()->format('Y'),
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'dailySalesData' => Transaction::dailySales($month, $year),
            'membershipPlans' => $membershipPlans,
            'membershipData' => $membershipData,
            'adminProfile'=> User::where('id', Auth::id())->first(),
            'liabilities'=>User::liabilityArr(),
        ]);
    }
}
