<?php

use App\Enums\SystemPrefix;
use App\Enums\TransactionType;
use App\Util\Enums;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($l = 1; $l <= 5; $l++) {

            $ref = Enums::LISTING_REFERENCE_PREFIX . rand(10000000, 99999999);
            $title = "This is a test listing title for ".$ref;

            DB::table('listings')->insert([
                'listing_ref_number' => $ref,
                'listing_title' => $title,
                'listing_slug' => Str::slug($title),
                'listing_description' => "Test description with some testing ? * & @ % /// punctuation marks and chaaaracters",
                'listing_thumbnail_url' => "https://picsum.photos/200/300",
                'member_id' => 1,
                'category_id' => 1,
                'transaction_type' => TransactionType::SALE,
                'pricing_option_id' => 1,
                'list_price' => doubleval(1000),
                "status" => 1,
                "detailable_type" => null,
                "detailable_id" => 0,
                "is_deleted" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "deleted_at" => null
            ]);
        }
    }
}
