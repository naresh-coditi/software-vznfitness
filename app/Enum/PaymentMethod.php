<?php

namespace App\Enum;

class PaymentMethod
{
    const CASH = ['name' => 'Cash', 'value' => '0', 'color' => 'bg-green-500/30 text-green-600'];
    const UPI = ['name' => 'Upi', 'value' => '1', 'color' => 'bg-blue-500/30 text-blue-600'];
    const CARD = ['name' => 'Card', 'value' => '3', 'color' => 'bg-yellow-500/30 text-yellow-600'];
    const EMI = ['name' => 'Emi', 'value' => '4', 'color' => 'bg-orange-500/30 text-orange-600'];

    public static function getPaymentMethod()
    {
        return [
            self::CASH,
            self::UPI,
            self::CARD,
            self::EMI
        ];
    }
}
