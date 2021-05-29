<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            'id' => 1,
            'paymentId' => 1,
            "name" => "ATM BNI",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('payment_methods')->insert([
            'id' => 2,
            'paymentId' => 1,
            "name" => "Mobile Banking BNI",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('payment_methods')->insert([
            'id' => 3,
            'paymentId' => 1,
            "name" => "Cabang atau Teller BNI",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('payment_methods')->insert([
            'id' => 4,
            'paymentId' => 1,
            "name" => "ATM Bank Lain",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('payment_methods')->insert([
            'id' => 5,
            'paymentId' => 2,
            "name" => "Gerai Indomaret",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('payment_methods')->insert([
            'id' => 6,
            'paymentId' => 3,
            "name" => "Gerai Alfamart",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }
}
