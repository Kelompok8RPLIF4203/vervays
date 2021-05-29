<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Payment
{
    public static function getName($paymentId)
    {
        return DB::table('payments')
                    ->where('id', $paymentId)
                    ->pluck('name')[0];
    }

    public static function getCodeName($paymentId)
    {
        return DB::table('payments')
                    ->where('id', $paymentId)
                    ->pluck('codeName')[0];
    }
}
