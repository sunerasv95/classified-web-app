<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('member_types')->insert([
            // 'id' => rand(1000, 2000),
            'member_type' => "Bronze Member",
            'description' => "tesfdfdfdf",
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('member_types')->insert([
            // 'id' => rand(1000, 2000),
            'member_type' => "Silver Member",
            'description' => "tesfdfdfdf",
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('member_types')->insert([
            // 'id' => rand(1000, 2000),
            'member_type' => "Gold Member",
            'description' => "tesfdfdfdf",
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('member_types')->insert([
            // 'id' => rand(1000, 2000),
            'member_type' => "Platinum Member",
            'description' => "tesfdfdfdf",
            'status' => 1,
            'is_deleted' => 0,
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
