<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Language extends Model
{
    public static function getLanguages()
    {
        return DB::table('languages')
                    ->select('id', 'name')
                    ->get()
                    ->all();
    }
}
