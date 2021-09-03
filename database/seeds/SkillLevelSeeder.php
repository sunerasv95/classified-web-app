<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = ["BEGINNER", "INTERMIDIATE", "ADVANCED", "PROFESSIONAL"];

        foreach($skills as $skill){
            DB::table('skill_levels')->insert([
                'skill_level' => $skill,
                "is_deleted" => 0,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => null
            ]);
        }
    }
}
