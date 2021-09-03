<?php

use App\Enums\WaveTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wave_types', function (Blueprint $table) {
            $table->id();
            $table->enum("wave_type", [
                WaveTypes::BEACH_BREAK,
                WaveTypes::POINT_BREAK,
                WaveTypes::REEF_BREAK
            ]);
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
        Schema::dropIfExists('wave_types');
    }
}
