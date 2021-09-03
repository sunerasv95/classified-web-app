<?php

use Carbon\Carbon;
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
        $materials = ["Epoxy", "Wood", "Other"];

        foreach($materials as $material){
            DB::table('materials')->insert([
                'material_name' => $material,
                'description' => "tesfdfdfdf",
                "is_deleted" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "deleted_at" => null
            ]);
        }

    }
}
