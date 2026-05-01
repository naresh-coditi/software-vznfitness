<?php

namespace App\Http\Controllers;

use App\Jobs\PaymentReminderJob;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class UserPaymentReminderController extends Controller
{
    public function byMail(User $user): RedirectResponse
    {
        dispatch(new PaymentReminderJob($user));
        flash('Email sent successfully', 'success');
        return back();
    }

    public function bySms(User $user)
    {
        try {
            $account_sid = getenv('TWILIO_ACCOUNT_SID');
            $auth_token = getenv('TWILIO_AUTH_TOKEN');

            // A Twilio number you own with SMS capabilities
            $twilio_number = "+14154888834";

            $client = new Client($account_sid, $auth_token);
            $res = $client->messages->create(
                // Where to send a text message (your cell phone?)
                '+917508449366',
                //  . $user->userProfile->phone,
                array(
                    'from' => $twilio_number,
                    'body' => "Hello " . $user->userProfile->fullName . " ,

We hope you're enjoying your time at Elite Edge Gym and Spa! To continue your fitness journey with us and access all our facilities, Don't miss out on achieving your goals with us. For more details or assistance, feel free to reach out to our front desk. Let's continue this journey together!

Best regards,
Elite Edge Gym and Spa"
                )
            );

            // if any error occur during sending sms
            if ($res->errorCode) {
                flash('Unable to send SMS notification', 'error');
                return back();
            }
            flash('SMS notification sent successfully', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong! Unable to send SMS notification', 'error');
            return back();
        }
    }
}
