<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('listing_details')->insert([
            'attribute_id' => 1,
            'listing_id' => 1,
            "attribute_value" => 100,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('listing_details')->insert([
            'attribute_id' => 2,
            'listing_id' => 1,
            "attribute_value" => 200,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('listing_details')->insert([
            'attribute_id' => 1,
            'listing_id' => 1,
            "attribute_value" => 100,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('listing_details')->insert([
            'attribute_id' => 4,
            'listing_id' => 1,
            "attribute_value" => 1,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('listing_details')->insert([
            'attribute_id' => 2,
            'listing_id' => 2,
            "attribute_value" => 1500,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('listing_details')->insert([
            'attribute_id' => 1,
            'listing_id' => 2,
            "attribute_value" => 500,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('listing_details')->insert([
            'attribute_id' => 1,
            'listing_id' => 3,
            "attribute_value" => 500,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('listing_details')->insert([
            'attribute_id' => 2,
            'listing_id' => 3,
            "attribute_value" => 800,
            "created_at" => now(),
            "updated_at" => now()
        ]);

    }
}
