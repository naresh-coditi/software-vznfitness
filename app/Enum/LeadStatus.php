<?php

namespace App\Enum;

class LeadStatus
{
    const OPEN = ['name' => 'Open', 'value' => 1, 'color' => 'bg-green-500/30 text-green-600'];
    const CLOSED = ['name' => 'Closed', 'value' => 0, 'color' => 'bg-red-500/30 text-red-600'];

    public static function leadStatus()
    {
        return [
            self::OPEN,
            self::CLOSED
        ];
    }
}
