<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_details', function (Blueprint $table) {
            $table->id();
            $table->string("width");
            $table->string("length");
            $table->string("thickness");
            $table->string("rail");
            $table->string("volume");
            $table->integer("wave_type_id");
            $table->integer("material_id");
            $table->integer("fin_type_id");
            $table->integer("brand_id");
            $table->json("functionalities")->nullable();
            $table->tinyInteger("status")->default(0);
            $table->tinyInteger("is_deleted")->default(0);
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
        Schema::dropIfExists('board_details');
    }
}
