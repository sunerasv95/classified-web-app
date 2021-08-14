<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string("user_code")->unique()->nullable();
            $table->integer('role_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('is_email_verified')->default(0);
            $table->tinyInteger('is_approved')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_blocked')->default(0);
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamp('approved_date')->nullable();
            $table->timestamp('blocked_date')->nullable();
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
        Schema::dropIfExists('admins');
    }
}
