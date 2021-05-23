<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            // 'id' => rand(69999, 99999),
            'brand_name' => "Brand 001",
            'brand_description' => "test",
            'brand_slug' => "category_slug",
            "brand_image_url" => "",
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('brands')->insert([
            // 'id' => rand(69999, 99999),
            'brand_name' => "Brand 002",
            'brand_description' => "test",
            'brand_slug' => "category_slug",
            "brand_image_url" => "",
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('brands')->insert([
            // 'id' => rand(69999, 99999),
            'brand_name' => "Brand 003",
            'brand_description' => "test",
            'brand_slug' => "category_slug",
            "brand_image_url" => "",
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('brands')->insert([
            // 'id' => rand(69999, 99999),
            'brand_name' => "Brand 004",
            'brand_description' => "test",
            'brand_slug' => "category_slug",
            "brand_image_url" => "",
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('brands')->insert([
            // 'id' => rand(69999, 99999),
            'brand_name' => "Brand 005",
            'brand_description' => "test",
            'brand_slug' => "category_slug",
            "brand_image_url" => "",
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);
    }
}
