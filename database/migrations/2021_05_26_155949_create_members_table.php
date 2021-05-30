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
            $table->string('is_organization')->default(0);
            $table->string('organization_name')->nullable();
            $table->integer("member_type_id");
            $table->text('bio')->nullable();
            $table->string('avatar_url')->nullable();
            $table->geometry('location')->nullable();
            $table->tinyInteger('is_email_verified')->default(0);
            $table->tinyInteger("is_active")->default(1);
            $table->tinyInteger("is_blocked")->default(0);
            $table->tinyInteger("is_deleted")->default(0);
            $table->timestamp("email_verified_at")->nullable();
            $table->timestamp("blocked_at")->nullable();
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
        Schema::dropIfExists('members');
    }
}
