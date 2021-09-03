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
            $table->decimal("length_ft", 6, 3)->nullable()->default(0);
            $table->decimal("length_in", 6, 3)->nullable()->default(0);
            $table->decimal("width_in", 6, 3)->nullable()->default(0);
            $table->decimal("thickness_cm", 6, 3)->nullable()->default(0);
            $table->decimal("rail_cm", 6, 3)->nullable()->default(0);
            $table->float("volume_ltr", 6, 1)->nullable()->default(0);
            $table->float("capacity_lbs", 6, 1)->nullable()->default(0);
            $table->integer("material_id");
            $table->integer("fin_type_id");
            $table->integer("brand_id");
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
        Schema::dropIfExists('board_details');
    }
}
