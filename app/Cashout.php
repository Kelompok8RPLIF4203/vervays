<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Cashout
{
    // Method ini digunakan untuk insert data ke tabel Cashout
    // @param $publisherId  : id publisher yang melakukan cashout
    // @param $bankId       : id bank tujuan
    // @param $amount       : jumlah withdrawal
    // @param $accountOwner :
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

    // Membuat id baru untuk digunakan pada saat insert data
    private static function getNewId()
    {
        return DB::table('cashouts')->get()->count() + 1;
    }
}
