<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Attributes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_attributes')->insert([
            'attribute_name' => "width",
            // 'category_id' =>  1,
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('detail_attributes')->insert([
            'attribute_name' => "height",
            // 'category_id' =>  1,
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('detail_attributes')->insert([
            'attribute_name' => "length",
            // 'category_id' =>  1,
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('detail_attributes')->insert([
            'attribute_name' => "has leash",
            // 'category_id' =>  1,
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('detail_attributes')->insert([
            'attribute_name' => "has wax",
            // 'category_id' =>  1,
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('detail_attributes')->insert([
            'attribute_name' => "color",
            // 'category_id' =>  1,
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('detail_attributes')->insert([
            'attribute_name' => "condition",
            // 'category_id' =>  1,
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('detail_attributes')->insert([
            'attribute_name' => "skill type",
            // 'category_id' =>  1,
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        DB::table('detail_attributes')->insert([
            'attribute_name' => "fin type",
            // 'category_id' =>  1,
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now()
        ]);
    }
}
