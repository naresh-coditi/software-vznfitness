<?php

namespace App\Enum;

class LiabilityRange
{
    public static function getLiabilityRange()
    {
        return [
            'range1' => '₹500 - ₹1000',
            'range2' => '₹1000 - ₹1200',
            'range3' => '₹1200 - ₹1500',
            'range4' => '₹1500 - ₹1800',
            'range5' => '₹1800 - ₹2000',
            'range6' => '₹2000+',
        ];
    }
}
