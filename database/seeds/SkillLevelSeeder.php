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
        DB::table('skill_levels')->insert([
            // 'id' => rand(59999, 79999),
            'skill_level_name' => "Beginner",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('skill_levels')->insert([
            // 'id' => rand(59999, 79999),
            'skill_level_name' => "Intermidiate",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('skill_levels')->insert([
            // 'id' => rand(59999, 79999),
            'skill_level_name' => "Expert",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('skill_levels')->insert([
            // 'id' => rand(59999, 79999),
            'skill_level_name' => "Pro",
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
