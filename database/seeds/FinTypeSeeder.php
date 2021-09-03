<?php

use Carbon\Carbon;
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
        $fins = ["Twin Fin", "Single Fin", "Thruster Fin", "Quad Fin", "Other"];

        foreach($fins as $fin){
            DB::table('fin_types')->insert([
                "fin_type_name" => $fin,
                "is_deleted" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "deleted_at" => null
            ]);
        }
    }
}
