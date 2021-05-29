<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(BankSeeder::class);
        // $this->call(LanguageSeeder::class);
        // $this->call(PaymentsSeeder::class);
        // $this->call(PaymentMethodsSeeder::class);
        // $this->call(StepSeeder::class);
        // $this->call(profile_photos_seeder::class);
        // $this->call(CategoriesSeeder::class);
        $this->call(FlashMessageAllotmentsSeeder::class);
    }
}
