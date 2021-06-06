<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => "Create Member",
            'slug' => Str::slug("Create Member"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => "Update Member",
            'slug' => Str::slug("Update Member"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => "Create Listing",
            'slug' => Str::slug("Update Listing"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => "Update Listing",
            'slug' => Str::slug("Update Listing"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => "Publish Listing",
            'slug' => Str::slug("Publish Listing"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => "Remove Listing",
            'slug' => Str::slug("Remove Listing"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => "Create Category",
            'slug' => Str::slug("Update Category"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'name' => "Update Category",
            'slug' => Str::slug("Update Category"),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }
}
