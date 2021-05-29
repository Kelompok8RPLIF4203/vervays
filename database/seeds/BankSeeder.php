<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->insert([
            'id' => 1,
            'name' => 'Bank Mandiri',
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('banks')->insert([
            'id' => 2,
            'name' => 'BNI',
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('banks')->insert([
            'id' => 3,
            'name' => 'BRI',
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('banks')->insert([
            'id' => 4,
            'name' => 'BCA',
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('banks')->insert([
            'id' => 5,
            'name' => 'Permata',
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }
}
