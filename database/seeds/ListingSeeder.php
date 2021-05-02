<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('listings')->insert([
            'listing_ref_number' => "PST".rand(10000, 99999),
            'listing_title' => Str::random(20),
            'listing_slug' => Str::random(20),
            'listing_description' => Str::random(10),
            'list_type' => 1,
            'category_id' => 3,
            'brand_id' => 1,
            'pricing_option_id' => 1,
            'list_price' => 1000,
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('listings')->insert([
            'listing_ref_number' => "PST".rand(10000, 99999),
            'listing_title' => Str::random(20),
            'listing_slug' => Str::random(20),
            'listing_description' => Str::random(10),
            'list_type' => 2,
            'category_id' => 3,
            'brand_id' => 2,
            'pricing_option_id' => 2,
            'list_price' => 100,
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('listings')->insert([
            'listing_ref_number' => "PST".rand(10000, 99999),
            'listing_title' => Str::random(20),
            'listing_slug' => Str::random(20),
            'listing_description' => Str::random(10),
            'list_type' => 2,
            'category_id' => 3,
            'brand_id' => 2,
            'pricing_option_id' => 3,
            'list_price' => 200,
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('listings')->insert([
            'listing_ref_number' => "PST".rand(10000, 99999),
            'listing_title' => Str::random(20),
            'listing_slug' => Str::random(20),
            'listing_description' => Str::random(10),
            'list_type' => 2,
            'category_id' => 4,
            'brand_id' => 4,
            'pricing_option_id' => 4,
            'list_price' => 600,
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);
    }
}
