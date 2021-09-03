<?php

use App\Util\Enums;
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
        $roles = array("Super Administrator", "Administrator", "Employee");

        foreach($roles as $role){
            DB::table('roles')->insert([
                'role_name'     => $role,
                'role_slug'     => Str::slug($role),
                'role_code'     => rand(8000,9999),
                'is_deleted'    => 0,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now(),
                "deleted_at"    => null
            ]);
        }
    }
}
