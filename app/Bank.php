<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Bank
{
    public static function getAllBank()
    {
        return DB::table('banks')->select('id', 'name')->get();
    }
}
