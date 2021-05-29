<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlashMessageAllotmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('flash_message_allotments')->insert([
            "id" => 1,
            "allotment" => "Email Verification Info",
        ]);

        DB::table('flash_message_allotments')->insert([
            "id" => 2,
            "allotment" => "Other",
        ]);
    }
}
