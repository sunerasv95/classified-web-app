<?php

use App\Util\Enums;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            "Surfboards", "Paddleboards", "Accessories", "Surf Shops", "Surf Camps"
        );

        $subCategories  = array(
            "Shortboards", "Longboards", "Fishboards", "Funboards"
        );

        foreach($categories as $cat){
            DB::table('categories')->insert([
                'category_name' => $cat,
                'category_description' => "test",
                'category_slug' => Str::slug($cat),
                'category_code' => Enums::CATEGORY_CODE_PREFIX.rand(1000, 3999),
                'is_parent' => 1,
                "parent_id" => 0,
                "status" => 1,
                "is_deleted" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "deleted_at" => null
            ]);
        }

        foreach($subCategories as $subCat){
            DB::table('categories')->insert([
                'category_name' => $subCat,
                'category_description' => "test",
                'category_slug' => Str::slug($subCat),
                'category_code' => Enums::CATEGORY_CODE_PREFIX.rand(1000, 3999),
                'is_parent' => 0,
                "parent_id" => 1,
                "status" => 1,
                "is_deleted" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "deleted_at" => null
            ]);
        }
    }
}
