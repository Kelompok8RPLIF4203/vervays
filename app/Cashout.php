<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Cashout
{
    public static function store($publisherId, $bankId, $amount, $accountOwner)
    {
        $now = Carbon::now();
        DB::table('cashouts')->insert([
            "id" => Cashout::getNewId(),
            "publisherId" => $publisherId,
            "bankId" => $bankId,
            "amount" => $amount,
            "accountOwner" => $accountOwner,
            "created_at" => $now,
            "updated_at" => $now,
        ]);
    }

    private static function getNewId()
    {
        return DB::table('cashouts')->get()->count() + 1;
    }
}
