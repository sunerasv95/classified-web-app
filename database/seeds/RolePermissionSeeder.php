<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_permission')->insert([
            'role_id' => 1,
            'permission_id' => 1,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('role_permission')->insert([
            'role_id' => 1,
            'permission_id' => 2,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('role_permission')->insert([
            'role_id' => 1,
            'permission_id' => 3,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('role_permission')->insert([
            'role_id' => 1,
            'permission_id' => 4,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('role_permission')->insert([
            'role_id' => 1,
            'permission_id' => 5,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('role_permission')->insert([
            'role_id' => 1,
            'permission_id' => 6,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('role_permission')->insert([
            'role_id' => 1,
            'permission_id' => 7,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('role_permission')->insert([
            'role_id' => 1,
            'permission_id' => 8,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('role_permission')->insert([
            'role_id' => 2,
            'permission_id' => 4,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('role_permission')->insert([
            'role_id' => 2,
            'permission_id' => 6,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }
}
