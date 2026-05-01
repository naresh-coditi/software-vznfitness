<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Models\PersonalTrainer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class PersonalTrainerTransactionController extends Controller
{
    public function index(User $user)
    {
        return view('admin.personaltrainer.transactions.index', [
            'users' => User::whereHas('personalTrainerPlans')
                ->with(['latestPersonalTrainerPlan', 'latestTransactions'])
                ->where('id', $user->id)
                ->get(),
            'user' => $user,
            'methods' => PaymentMethod::getPaymentMethod(),
            'request' => request()
        ]);
    }
    public function store(User $user, Request $request)
    {
        $request->validate([
            'note' => 'nullable|string',
            'method_type' => 'required|string',
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($user, $request) {
                $transactionData = [
                    'user_id' => $user->id,
                    'transaction_date' => $request->transaction_date,
                    'method_type' => $request->method_type,
                    'note' => $request->note,
                    'created_by' => Auth::id(),
                    'amount' => $request->amount,
                    'remaining_amount' => $request->remaining_amount,
                ];

                Transaction::create($transactionData);
                $personalTrainer = PersonalTrainer::where('member_id', $user->id)->latest()->firstOrFail();
                $personalTrainer->update([
                    'amount' => $personalTrainer->amount + $request->amount,
                    'remaining_balance' => $request->remaining_amount,
                ]);
            });

            flash('Transaction added successfully', 'success');
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to add transaction', 'error');
        }

        return back();
    }

    public function edit($transaction)
    {
        $data = Transaction::find($transaction);
        return view('admin.personaltrainer.transactions.edit', [
            'transaction' => $data,
            'methods' => PaymentMethod::getPaymentMethod(),
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric',
            'remaining_balance' => 'nullable|numeric',
            'method_type' => 'required|string',
            'note' => 'nullable|string',
        ]);
        try {
            $transaction->update([
                'transaction_date' => $request->transaction_date,
                'amount' => $request->amount,
                'remaining_amount' => $request->remaining_balance,
                'method_type' => $request->method_type,
                'note' => $request->note,
            ]);
            flash('Transaction updated successfully.', 'success');
            return redirect()->route('transactions.index');
        } catch (\Throwable $th) {

            return redirect()->back()->withErrors(['error' => 'Failed to update transaction: ' . $th->getMessage()]);
        }
    }


    public function delete(Transaction $transaction)
    {
        try {
            $personalTrainer = PersonalTrainer::where('member_id', $transaction->user_id)->latest()->firstOrFail();

            $newAmount = $personalTrainer->amount - $transaction->amount;
            $newRemainingBalance = $personalTrainer->remaining_balance + $transaction->amount;


            $personalTrainer->update([
                'amount' => $newAmount,
                'remaining_balance' => $newRemainingBalance,
            ]);

            $transaction->delete();

            flash('Transaction deleted successfully', 'success');
        } catch (\Throwable $th) {
            Log::error($th);
            flash('Unable to remove transaction', 'error');
        }

        return back();
    }
}
