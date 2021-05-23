<?php

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
        DB::table('board_details')->insert([
            // 'id' => rand(1000000000, 9999999999),
            'width' => "150 cm",
            'length' => "200cm",
            'thickness' => "20cm",
            'rail' => "20cm",
            'volume' => "20l",
            "wave_type_id" => 1,
            "material_id" => 1,
            "fin_type_id" => 1,
            "brand_id" => 1,
            "functionalities" => json_encode([
                "has_leash" => 1,
                "has_fins" => 1
            ]),
            "status" => 1,
            "created_at" => now(),
            "updated_at" => now(),
            "deleted_at" => null
        ]);


        DB::table('board_details')->insert([
            // 'id' => rand(1000000000, 9999999999),
            'width' => "100 cm",
            'length' => "200 m",
            'thickness' => "10c",
            'rail' => "20cm",
            'volume' => "50l",
            "wave_type_id" => 2,
            "material_id" => 1,
            "fin_type_id" => 2,
            "brand_id" => 1,
            "functionalities" => json_encode([
                "has_leash" => 1,
                "has_fins" => 1
            ]),
            "status" => 1,
            "created_at" => now(),
            "updated_at" => now(),
            "deleted_at" => null
        ]);

    }
}
