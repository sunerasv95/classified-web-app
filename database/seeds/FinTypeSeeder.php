<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fin_types')->insert([
            // "id" => rand(4999, 5999),
            'fin_type_name' => "Twin Fin",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('fin_types')->insert([
            // "id" => rand(4999, 6999),
            'fin_type_name' => "Single Fin",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('fin_types')->insert([
            // "id" => rand(4999, 6999),
            'fin_type_name' => "Thruster Fin",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('fin_types')->insert([
            // "id" => rand(4999, 6999),
            'fin_type_name' => "Quad Fin",
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        DB::table('fin_types')->insert([
            // "id" => rand(4999, 6999),
            'fin_type_name' => "Other",
            "created_at" => now(),
            "updated_at" => now(),
        ]);
    }
}
