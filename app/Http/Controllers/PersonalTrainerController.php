<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Enum\UserType;
use App\Models\PersonalTrainer;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PersonalTrainerController extends Controller
{
    public function index()
    {
        return view('admin.personaltrainer.index', [
            'users' => User::whereHas('personalTrainerPlans')->with('latestPersonalTrainerPlan')->filter(request())->paginate(50),
            'request' => request()
        ]);
    }

    public function create()
    {
        return view('admin.personaltrainer.create', [
            'users' => User::where('role_id', User::User)->get(),
            'methods' => PaymentMethod::getPaymentMethod(),
            'trainers' => User::with('UserProfile')->where('role_id', User::Trainer)->get(),

        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member' => 'required|exists:users,id',
            'trainer' => 'required',
            'amount' => 'required|min:0',
            'remaining_balance' => 'required|min:0',
            'duration' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'method_type' => 'required'
        ]);
        try {
            DB::transaction(function () use ($request) {
                $trainer = User::find($request->trainer);
                PersonalTrainer::create([
                    'member_id' => $request->member,
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
                    'user_id' => $request->member,
                    'transaction_date' => today(),
                    'method_type' => $request->method_type,
                    'note' => 'Personal traning payment',
                    'created_by' => Auth::id(),
                    'amount' => $request->amount,
                    'remaining_amount' => $request->remaining_balance,
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

    public function edit(PersonalTrainer $data)
    {
        return view('admin.personaltrainer.edit', [
            'data' => $data,
            'users' => User::where('role_id', User::User)->get(),
            'methods' => PaymentMethod::getPaymentMethod(),
            'trainers' => User::where('role_id', User::Trainer)->get(),
        ]);
    }

    public function view(PersonalTrainer $data)
    {
        return view('admin.personaltrainer.view', [
            'data' => $data,
            'users' => User::where('role_id', User::User)->get()
        ]);
    }

    public function update(PersonalTrainer $data, Request $request)
    {
        $request->validate([
            'member' => 'required|exists:users,id',
            'trainer' => 'required',
            'amount' => 'required|min:0',
            'remaining_balance' => 'required|min:0',
            'duration' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'method_type' => 'required'
        ]);

        try {
            $trainer = User::find($request->trainer);
            $data->update([
                'member_id' => $request->member,
                'trainer' => $trainer->userProfile->fullName,
                'trainer_id' => $request->trainer,
                'duration' => $request->duration,
                'amount' => $request->amount,
                'remaining_balance' => $request->remaining_balance,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'method_type' => $request->method_type
            ]);

            flash('Personal Trainer details updated successfully', 'success');
            return to_route(Auth::user()->roleName . 'pt.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to update details', 'error');
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
