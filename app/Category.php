<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    public static function getCategories()
    {
        return DB::table('categories')
                    ->select('id', 'name')
                    ->orderBy('name')
                    ->get()
                    ->all();
    }
}
