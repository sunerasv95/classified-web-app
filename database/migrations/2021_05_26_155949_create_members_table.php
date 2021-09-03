<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string("username")->unique();
            $table->string("email")->unique();
            $table->string("password");
            $table->tinyInteger('is_email_verified')->default(0);
            $table->string("member_code")->unique();
            $table->tinyInteger("member_type_id")->nullable();
            $table->string('is_store')->default(0);
            $table->string('store_name')->nullable();
            $table->text('store_description')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->integer('city_id')->nullable();
            $table->geometry('geo_location')->nullable();
            $table->tinyInteger("status")->default(0);
            $table->tinyInteger("is_deleted")->default(0);
            $table->timestamps();
            $table->timestamp("email_verified_at")->nullable();
            $table->timestamp("blocked_at")->nullable();
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
        Schema::dropIfExists('members');
    }
}
