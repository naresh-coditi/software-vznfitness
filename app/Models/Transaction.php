<?php

namespace App\Models;

use App\Enum\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'transaction_date',
        'method_type',
        'note',
        'created_by',
        'amount',
        'remaining_amount'
    ];

    // Scope
    public function scopeFilter($query, $request)
    {
        $query->when($request->search ?? false, function ($query, $search) {
            $query->where('amount', 'LIKE', '%' . $search . '%')
                ->orwhere('method_type', 'LIKE', '%' . $search . '%')
                ->orwhereHas('user', function ($query) use ($search) {
                    $query->where('phone', 'LIKE', '%' . $search . '%')
                        ->orWhere('member_id', 'LIKE', '%' . $search . '%')
                        ->orWhereHas('userProfile', function ($query) use ($search) {
                            $query->where('first_name', 'LIKE', '%' . $search . '%')
                                ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                        });
                });
        });
    }

    //  Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed()->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function scopeMinYear($query)
    {
        return $query->first() ? $query->first()->created_at->format('Y') : Carbon::now()->format('Y');
    }

    public function scopeDailySales($query, $month, $year)
    {
        $data = $query->whereMonth('transaction_date', $month)->whereYear('transaction_date', $year)->get()->groupBy('transaction_date')->map(function ($data) {
            return [
                'total' => $data->sum('amount'),
                'emi' => $data->where('method_type', PaymentMethod::EMI['name'])->sum('amount'),
                'cash' => $data->where('method_type', PaymentMethod::CASH['name'])->sum('amount'),
                'upi' => $data->whereIn('method_type', [PaymentMethod::UPI['name'], 'UPI'])->sum('amount'),
                'card' => $data->where('method_type', PaymentMethod::CARD['name'])->sum('amount'),
            ];
        });

        return $data;
    }

    public function scopeMonthlySales($query, $month, $year)
    {
        $emi = clone $query;
        $cash = clone $query;
        $upi = clone $query;
        $card = clone $query;

        $emi = $emi->where('method_type', PaymentMethod::EMI['name'])->whereMonth('transaction_date', $month)->whereYear('transaction_date', $year)->sum('amount');
        $cash = $cash->where('method_type', PaymentMethod::CASH['name'])->whereMonth('transaction_date', $month)->whereYear('transaction_date', $year)->sum('amount');
        $upi = $upi->whereIn('method_type', [PaymentMethod::UPI['name'], 'UPI'])->whereMonth('transaction_date', $month)->whereYear('transaction_date', $year)->sum('amount');
        $card = $card->where('method_type', PaymentMethod::CARD['name'])->whereMonth('transaction_date', $month)->whereYear('transaction_date', $year)->sum('amount');

        return [
            'EMI' => $emi,
            'CASH' => $cash,
            'UPI' => $upi,
            'CARD' => $card
        ];
    }

    public function scopeSalesByPaymentMentod($query, $type)
    {
        $query->when($type ?? null, function ($query, $type) {
            $query->where('method_type', $type);
        });
    }

    public function scopeDateRange($query, $dates)
    {
        $query->when($dates ?? null, function ($query, $dates) {
            $date = explode(' - ', $dates);
            $query->whereBetween('transaction_date', [Carbon::parse($date[0])->format('Y-m-d'), Carbon::parse($date[1])->format('Y-m-d')]);
        });
    }

    // Attrinbutes
    public function transactionDate(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return dateFormat($value);
            }
        );
    }
    // Relation
    public function createdByProfile()
    {
        return $this->hasOneThrough(UserProfile::class, User::class, 'id', 'user_id', 'created_by', 'id')->withDefault();
    }

    public function userProfile()
    {
        return $this->hasOneThrough(UserProfile::class, User::class, 'id', 'user_id', 'user_id', 'id')->withDefault();
    }
}
