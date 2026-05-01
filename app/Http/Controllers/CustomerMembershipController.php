<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Services\AddMembershipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerMembershipController extends Controller
{
    protected AddMembershipService $memberService;

    public function __construct()
    {
        $this->memberService = new AddMembershipService();
    }

    public function index(): View
    {
        return view('customer.memberships.index', [
            'user' => Auth::user(),

        ]);
    }

    public function view(): View
    {
        return view('customer.memberships.view', [
            'plans' => MembershipPlan::isActive()->get()
        ]);
    }

    public function create(Request $request): View
    {
        $plans = $this->memberService->attachDates($request);

        return view('customer.memberships.create', [
            'plans' => $plans,
            'amount' => MembershipPlan::whereIn('id', $request->plans)->pluck('cost')->sum(),
            'validDate' => $request['selected_date']
        ]);
    }
}
