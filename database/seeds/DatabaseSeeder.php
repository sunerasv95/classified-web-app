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
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(PricingOptionSeeder::class);
        $this->call(ListingSeeder::class);
        $this->call(ListingImageSeeder::class);
    }
}
