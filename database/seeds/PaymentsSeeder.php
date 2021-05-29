<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            'id' => 1,
            'name' => 'BNI Virtual Account',
            "codeName" => "No Virtual Account",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('payments')->insert([
            'id' => 2,
            'name' => 'Indomaret',
            "codeName" => "Kode pembayaran",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('payments')->insert([
            'id' => 3,
            'name' => 'Alfamart',
            "codeName" => "Kode pembayaran",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }
}
