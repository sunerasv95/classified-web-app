<?php

use App\Enums\TransactionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string("listing_ref_number", 25)->unique();
            $table->string("listing_title", 150);
            $table->string("listing_slug" , 150)->unique();
            $table->text("listing_description", 500);
            $table->integer('member_id')->unsigned();
            $table->integer("category_id");
            $table->enum("transaction_type", [TransactionType::SALE, TransactionType::RENT]);
            $table->integer("pricing_option_id");
            $table->float("list_price", 18, 2);
            $table->longText("listing_thumbnail_url", 100)->nullable($value = true);
            $table->string("detailable_type")->nullable();
            $table->integer("detailable_id")->default(0);
            $table->timestamp("published_at")->nullable($value = true);
            $table->tinyInteger("status")->default(0);
            $table->tinyInteger("is_deleted")->default(0);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
