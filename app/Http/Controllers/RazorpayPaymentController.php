<?php

namespace App\Http\Controllers;

use App\Services\AddMembershipService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class RazorpayPaymentController extends Controller
{
    protected AddMembershipService $memberService;

    public function __construct()
    {
        $this->memberService = new AddMembershipService();
    }
    /**
     * Write code on Method
     *
     * @return response()
     */

    public function store(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $this->memberService->addPlanViaOnline($request, $response, Auth::user());
            } catch (Exception $e) {
                Log::error($e);
                flash('Something went wrong', 'error');
                return redirect()->back();
            }
        }
        flash('Payment successful', 'success');
        return to_route('user.membership.index');
    }
}
