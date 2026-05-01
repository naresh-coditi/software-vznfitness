<?php

namespace App\Http\Controllers;

use App\Enum\MonthNames;
use App\Enum\UserType;
use App\Models\LeadUser;
use App\Models\MembershipPlan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserMembershipDetail;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('m');
        $year = $request->year ?? Carbon::now()->format('Y');
        $plans = UserMembershipDetail::planExpiringsoon()->paginate(50)->all();
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

        if (!session()->has('plans_shown') && !empty($plans)) {
            session()->flash('plans', $plans);
            session(['plans_shown' => true]);  // Setting a flag to indicate the popup was shown
        }

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
            'leads' => LeadUser::with(['createdBy', 'notes', 'createdByProfile'])->filter(request())->followUpLeadToday()->paginate(20),
            'dailySalesData' => Transaction::dailySales($month, $year),
            'plans' => $plans,
            'membershipPlans' => $membershipPlans,
            'membershipData' => $membershipData,
            'adminProfile'=> User::where('id', Auth::id())->first(),
            'liabilities'=>User::liabilityArr(),
        ]);
    }
}
