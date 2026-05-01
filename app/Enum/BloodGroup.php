<?php

namespace App\Enum;

class BloodGroup
{
    public static function getBloodGroups()
    {
        return [
            'A+',
            'A-',
            'B+',
            'B-',
            'AB+',
            'AB-',
            'O+',
            'O-'
        ];
    }
}
