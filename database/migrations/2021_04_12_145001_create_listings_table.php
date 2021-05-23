<?php

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
            $table->string("listing_ref_number", 25);
            $table->string("listing_title", 150);
            $table->string("listing_slug" , 150);
            $table->string("listing_description", 300);
            $table->integer("list_type");
            $table->integer("category_id");
            $table->integer("pricing_option_id");
            $table->float("list_price", 18, 2);
            $table->tinyInteger("is_published")->default(0);
            $table->timestamp("published_at")->nullable($value = true);
            $table->tinyInteger("status")->default(0);
            $table->tinyInteger("is_deleted")->default(0);
            $table->string("detailable_type")->nullable();
            $table->integer("detailable_id")->default(0);
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
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
