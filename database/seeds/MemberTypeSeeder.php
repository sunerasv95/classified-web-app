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
        $memberships = ["Basic", "Bronze", "Silver", "Gold"];

        foreach($memberships as $membership){
            DB::table('membership_types')->insert([
                'membership_type' => $membership,
                'description' => "tesfdfdfdf",
                'status' => 1,
                'is_deleted' => 0,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => null
            ]);
        }
    }
}
