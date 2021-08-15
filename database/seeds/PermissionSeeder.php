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
        $actions = array("View", "Create", "Update", "Delete");
        $models = array("Member", "Listing", "Category", "Roles", "Permission", "Brand");

        foreach ($models as $k => $model) {
            foreach ($actions as $k => $action) {
                $permissionName = $action." ".$model;
                DB::table('permissions')->insert([
                    'permission_name' => $permissionName,
                    'permission_slug' => Str::slug($permissionName),
                    'permission_code' => rand(3000, 6999),
                    "status" => 1,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);
            }
        }
    }
}
