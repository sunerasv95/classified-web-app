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
        DB::table('wave_types')->insert([
            // 'id' => rand(1999, 3999),
            'wave_type' => "1-2ft",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('wave_types')->insert([
            // 'id' => rand(1999, 3999),
            'wave_type' => "3-5ft",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('wave_types')->insert([
            // 'id' => rand(1999, 3999),
            'wave_type' => "5-8ft",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('wave_types')->insert([
            // 'id' => rand(1999, 3999),
            'wave_type' => "10ft",
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
