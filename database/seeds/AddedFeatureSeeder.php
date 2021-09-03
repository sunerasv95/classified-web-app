<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddedFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            "Has Leash",
            "Has Fins",
            "Has Daybag",
            "Has Boardsocks",
            "Has Roof racks"
        ];

        foreach($features as $feature){
            DB::table('added_features')->insert([
                'feature_name' => $feature,
                "status" => 1,
                "is_deleted" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "deleted_at" => null
            ]);
        }
    }
}
