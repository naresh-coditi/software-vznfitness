<?php

namespace App\Enum;

class ApproachStatus{
    public static function getApproachStatus(){
        return[
            0 => 'Pending',
            1 => 'Done',
        ];
    }
}