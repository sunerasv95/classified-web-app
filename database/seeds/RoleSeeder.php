<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => "Super Administrator",
            'slug' => Str::slug("Super Administrator"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => "Administrator",
            'slug' => Str::slug("Administrator"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }
}
