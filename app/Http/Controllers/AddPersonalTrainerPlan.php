<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Models\PersonalTrainer;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddPersonalTrainerPlan extends Controller
{
    public function index(User $user)
    {
        return view('admin.personaltrainer.addplan.index', [
            'user' => $user,
            'datas' => $user->personalTrainerPlans()->latest()->paginate(20),
            'methods' => PaymentMethod::getPaymentMethod(),
            'trainers' => User::where('role_id', User::Trainer)->get(),
        ]);
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'trainer' => 'required',
            'amount' => 'required|min:0',
            'remaining_balance' => 'required|min:0',
            'duration' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'method_type' => 'required'
        ]);

        try {
            DB::transaction(function () use ($request, $user) {
                $trainer = User::find($request->trainer);
                PersonalTrainer::create([
                    'member_id' => $user->id,
                    'trainer' => $trainer->userProfile->fullName,
                    'trainer_id' => $request->trainer,
                    'duration' => $request->duration,
                    'amount' => $request->amount,
                    'remaining_balance' => $request->remaining_balance,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'method_type' => $request->method_type
                ]);

                Transaction::create([
                    'user_id' => $user->id,
                    'transaction_date' => today(),
                    'method_type' => $request->method_type,
                    'note' => 'Personal traning payment',
                    'created_by' => Auth::id(),
                    'amount' => $request->amount,
                ]);
            });
            flash('Personal Trainer details added successfully', 'success');
            return to_route(Auth::user()->roleName . 'pt.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to add details', 'error');
            return back();
        }
    }

    public function delete(PersonalTrainer $data)
    {
        try {
            $data->delete();
            flash('Personal trainer details deleted successfully.', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to delete.', 'error');
            return back();
        }
    }
}
