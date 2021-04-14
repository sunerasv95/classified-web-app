<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pricing_options')->insert([
            'pricing_option' => "Sale Price",
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('pricing_options')->insert([
            'pricing_option' => "10 days/Rent",
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('pricing_options')->insert([
            'pricing_option' => "1 day/Rent",
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('pricing_options')->insert([
            'pricing_option' => "7 days/Rent",
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);
    }
}
