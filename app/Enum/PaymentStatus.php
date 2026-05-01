<?php

namespace App\Enum;

class PaymentStatus
{
    const FAILED = ['name' => 'failed', 'value' => '0','color' => 'bg-red-500/30 text-red-600'];
    const SUCCESS = ['name' => 'succeeded', 'value' => '1','color' => 'bg-green-500/30 text-green-600'];
    const INCOMPLETE = ['name' => 'pending', 'value' => '2','color' => 'bg-yellow-500/30 text-yellow-600'];
    const UNCAPTURED = ['name' => 'uncaptured', 'value' => '3','color' => 'bg-gray-500/30 text-gray-600'];
    const WAITING = ['name' => 'waiting', 'value' => '4','color' => 'bg-orange-500/30 text-orange-600'];

    public static function paymentStatusCode()
    {
        return [
            self::FAILED,
            self::SUCCESS,
            self::INCOMPLETE,
            self::UNCAPTURED,
            self::WAITING
        ];
    }
}
