<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Bank
{
    // Method ini digunakan untuk mengambil data semua bank dari database
    public static function getAllBank()
    {
        return DB::table('banks')->select('id', 'name')->get();
    }
}
