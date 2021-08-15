<?php

use App\Util\Enums;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 10;
        for($i = 1; $i <= $count; $i++){
            $brandName =  "Brand". "00".$i;
            DB::table('brands')->insert([
                'brand_name' =>$brandName,
                'brand_description' => "test",
                'brand_slug' => Str::slug($brandName),
                "brand_code" => Enums::BRAND_CODE_PREFIX.rand(1000, 5000),
                "brand_image_url" => "",
                "status" => 1,
                "is_deleted" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "deleted_at" => null
            ]);
        }
    }
}
