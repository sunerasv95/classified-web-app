<?php

use App\Enums\SkillLevels;
use App\Enums\WaveTypes;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BoardDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i <= 3;$i++){
            DB::table('board_details')->insert([
                'length_ft' => 7.000,
                'length_in' => 12.000,
                'width_in' => 6.000,
                'thickness_cm' => 12.000,
                'rail_cm' => 12.000,
                'volume_ltr' => 2000.9,
                'capacity_lbs' => 2000.0,
                "material_id" => 0,
                "fin_type_id" => 0,
                "brand_id" => 0,
                "status" => 1,
                "is_deleted" => 0,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => null
            ]);

            DB::table('board_skill_level')->insert([
                'board_detail_id' => $i,
                'skill_level_id' => 1,
                'is_deleted' => 0,
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            DB::table('board_wave_type')->insert([
                'board_detail_id' => $i,
                'wave_type_id' => 1,
                'is_deleted' => 0,
                "created_at" => now(),
                "updated_at" => now()
            ]);

        }
    }
}
