<?php

namespace App\Enum;

class UserType
{
    const LEAD = ['name' => 'Lead', 'value' => '0','color' => 'bg-yellow-500/30 text-yellow-600'];
    const MEMBER = ['name' => 'Member', 'value' => '1', 'color' => 'bg-blue-500/30 text-blue-600'];

    public static function getUserType()
    {
        return [
            self::LEAD,
            self::MEMBER
        ];
    }
}
