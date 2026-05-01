<?php

namespace App\Http\Controllers;

use App\Models\MembershipPlan;
use App\Models\User;
use App\Services\AddMembershipService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Razorpay\Api\Api;

class AdminAddMembershipController extends Controller
{
    protected AddMembershipService $memberService;

    public function __construct()
    {
        $this->memberService = new AddMembershipService();
    }

    public function index(User $user): View
    {
        return view('admin.addMembershipPlan.index', [
            'plans' => MembershipPlan::isActive()->get(),
            'user' => $user
        ]);
    }

    public function create(User $user, Request $request): View
    {
        $plans = $this->memberService->attachDates($request);

        return view('admin.addMembershipPlan.create', [
            'plans' => $plans,
            'amount' => MembershipPlan::whereIn('id', $request->plans)->pluck('cost')->sum(),
            'validDate' => $request['selected_date'],
            'user' => $user
        ]);
    }

    public function store(User $user, Request $request)
    {
        $input = $request->all();

        if (count($input)  && !empty($input['razorpay_payment_id'])) {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $payment = $api->payment->fetch($input['razorpay_payment_id']);

            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $this->memberService->addPlanViaOnline($request, $response, $user);

                flash('Payment successful', 'success');
                return to_route(Auth::user()->roleName . 'user.view', $user);
            } catch (Exception $e) {
                Log::error($e);
                flash('Something went wrong', 'error');
                return to_route(Auth::user()->roleName . 'user.view', $user);
            }
        } elseif (count($input)) {
            try {
                $this->memberService->addPlanViaCash($request, $user);

                flash('Payment successful', 'success');
                return to_route(Auth::user()->roleName . 'user.view', $user);
            } catch (Exception $e) {
                Log::error($e);
                flash('Something went wrong', 'error');
                return to_route(Auth::user()->roleName . 'user.view', $user);
            }
        }

        flash('No Data Found', 'error');
        return to_route(Auth::user()->roleName . 'user.view', $user);
    }
}
