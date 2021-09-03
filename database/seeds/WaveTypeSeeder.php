<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $waves = ["BEACH_BREAK", "POINT_BREAK", "REEF_BREAK"];

        foreach($waves as $wave){
            DB::table('wave_types')->insert([
                'wave_type' => $wave,
                "is_deleted" => 0,
                "created_at" => now(),
                "updated_at" => now(),
                "deleted_at" => null
            ]);
        }
    }
}
