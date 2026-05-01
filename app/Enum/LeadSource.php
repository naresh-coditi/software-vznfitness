<?php

namespace App\Enum;

class LeadSource
{
    const WALKIN = ['id' => 1, 'name' => 'Walk-In'];
    const REFRENCE = ['id' => 2, 'name' => 'Reference'];
    const PHONECALL = ['id' => 3, 'name' => 'Phone Call'];
    const SOCIALMEDIA = ['id' => 4, 'name' => 'Social Media'];

    public static function getLeadSource()
    {
        return [
            self::WALKIN,
            self::REFRENCE,
            self::PHONECALL,
            self::SOCIALMEDIA
        ];
    }
}
