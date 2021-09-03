<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i=1; $i <=5; $i++){
            DB::table('listing_images')->insert([
                'listing_img_url' => "https://picsum.photos/200/300",
                'listing_id' => 1,
                "is_deleted" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "deleted_at" => null
            ]);
        }

    }
}
