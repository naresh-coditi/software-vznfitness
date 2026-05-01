<?php

namespace App\Enum;

class UserRoleEnum
{
    const ADMIN = ['name' => 'Admin', 'value' => '1','color' => 'bg-blue-500/30 text-blue-600'];
    const USER = ['name' => 'User', 'value' => '3', 'color' => 'bg-gray-500/30 text-gray-600'];
    const STAFF = ['name' => 'Staff', 'value' => '2', 'color' => 'bg-blue-500/30 text-blue-600'];

    public static function getUserType()
    {
        return [
            self::ADMIN,
            self::USER,
            self::STAFF
        ];
    }
}
