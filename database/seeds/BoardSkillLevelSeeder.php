<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardSkillLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('board_skill_level')->insert([
            'board_detail_id' => 1,
            'skill_level_id' => 1,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('board_skill_level')->insert([
            'board_detail_id' => 1,
            'skill_level_id' => 2,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('board_skill_level')->insert([
            'board_detail_id' => 1,
            'skill_level_id' => 3,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('board_skill_level')->insert([
            'board_detail_id' => 2,
            'skill_level_id' => 2,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('board_skill_level')->insert([
            'board_detail_id' => 2,
            'skill_level_id' => 3,
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
