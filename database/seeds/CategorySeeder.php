<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            // 'id' => rand(59999, 99999),
            'category_name' => "Surfboards",
            'category_description' => "test",
            'category_slug' => "category_slug",
            'is_parent' => 1,
            "parent_id" => 0,
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('categories')->insert([
            // 'id' => rand(59999, 99999),
            'category_name' => "Paddleboards",
            'category_description' => "test",
            'category_slug' => "category_slug",
            'is_parent' => 1,
            "parent_id" => 0,
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);

        DB::table('categories')->insert([
            // 'id' => rand(59999, 99999),
            'category_name' => "Shortboards",
            'category_description' => "test",
            'category_slug' => "category_slug",
            'is_parent' => 0,
            "parent_id" => 1,
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);


        DB::table('categories')->insert([
            // 'id' => rand(59999, 99999),
            'category_name' => "longboards",
            'category_description' => "test",
            'category_slug' => "category_slug",
            'is_parent' => 0,
            "parent_id" => 1,
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);


        DB::table('categories')->insert([
            // 'id' => rand(59999, 99999),
            'category_name' => "Sup boards",
            'category_description' => "test",
            'category_slug' => "category_slug",
            'is_parent' => 0,
            "parent_id" => 2,
            "status" => 1,
            "is_deleted" => 0,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "deleted_at" => null
        ]);
    }
}
