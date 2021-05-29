<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            "Seni dan musik",
            "Fotografi",
            "Otomotif",
            "Biografi",
            "Bisnis",
            "Keuangan",
            "Anak anak",
            "Hiburan",
            "Fashion",
            "Makanan",
            "Resep",
            "Kesehatan",
            "Kecantikan",
            "Hobi",
            "Rumah",
            "Gaya hidup",
            "Budaya",
            "Poltik",
            "Parenting",
            "Travel",
            "Ensiklopedia",
            "Sains",
            "Olahraga",
        ];
        for ($i=1; $i <= count($arr); $i++) {
            DB::table('categories')->insert([
                "id" => $i,
                "name" => $arr[$i-1],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
        }
    }
}
