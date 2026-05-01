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

class TransactionController extends Controller
{
    public function index(User $user)
    {
        return view('admin.user.transaction.index', [
            'user' => $user,
            'transactions' => Transaction::where('user_id', $user->id)->orderBy('transaction_date','desc')->paginate(50),
            'methods' => PaymentMethod::getPaymentMethod(),
            'request' => request()
        ]);
    }
    public function store(User $user, Request $request)
    {
        $request->validate([
            'note' => 'nullable',
            'method_type' => 'required',
            'transaction_date' => 'required|date',
            'amount' => 'required|min:0',
        ]);

        try {
            DB::transaction(function () use ($user, $request) {
                Transaction::create([
                    'user_id' => $user->id,
                    'transaction_date' => $request->transaction_date,
                    'method_type' => $request->method_type,
                    'note' => $request->note,
                    'created_by' => Auth::id(),
                    'amount' => $request->amount,
                    'remaining_amount' => $request->remaining_amount,
                ]);

                $user->membershipDetails->update([
                    'remaining_amount' => $request->remaining_amount,
                    'amount' => $user->membershipDetails->amount + $request->amount,
                ]);
            });

            flash('Transaction added successfully', 'success');
            return back();
        } catch (Exception $e) {
            Log::error($e);
            flash('Something went wrong. Unable to add transaction', 'error');
            return back();
        }
    }
    public function edit($transaction)
    {
        $data = Transaction::find($transaction);
        return view('admin.user.transaction.edit', [
            'transaction' => $data,
            'methods' => PaymentMethod::getPaymentMethod(),
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user->membershipDetails->amount < $transaction->amount) {
            flash('Your Total Paid Amount Is Low', 'error');
            return back();
        }
        $amount= $transaction->user->membershipDetails->amount - $transaction->amount;
        $finalAmount=$amount + $request->amount;
        $request->validate([
            'transaction_date' => 'required|date',
            'amount' => 'required|numeric',
            'remaining_balance' => 'nullable|numeric',
            'method_type' => 'required|string',
            'note' => 'nullable|string',
        ]);

        try {
            $amount = $transaction->user->membershipDetails->amount  - $transaction->amount;
            $transaction->update([
                'transaction_date' => $request->transaction_date,
                'amount' => $request->amount,
                'remaining_amount' => $request->remaining_balance,
                'method_type' => $request->method_type,
                'note' => $request->note,
            ]);
            $transaction->user->membershipDetails->update([
                'amount' => $finalAmount
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
            $amount = $transaction->user->membershipDetails->amount  - $transaction->amount;

            $transaction->user->membershipDetails->update([
                'amount' => $amount
            ]);

            $transaction->delete();
            flash('Transaction deleted successfully', 'success');
            return back();
        } catch (\Throwable $th) {
            Log::info($th);
            flash('Unable to remove transaction', 'error');
            return back();
        }
    }
}
