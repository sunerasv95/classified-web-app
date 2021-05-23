<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materials')->insert([
            // 'id' => rand(1000, 2000),
            'material_name' => "Epoxy",
            'description' => "tesfdfdfdf",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('materials')->insert([
            // 'id' => rand(1000, 2000),
            'material_name' => "Wood",
            'description' => "tesfdfdfdf",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('materials')->insert([
            // 'id' => rand(1000, 2000),
            'material_name' => "Ploester",
            'description' => "tesfdfdfdf",
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
