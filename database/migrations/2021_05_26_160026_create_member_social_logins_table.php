<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberSocialLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_social_logins', function (Blueprint $table) {
            $table->id();
            $table->integer("member_id");
            $table->string("provider");
            $table->string("provider_id");
            $table->tinyInteger('is_revoked')->default(0);
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
        Schema::dropIfExists('member_social_logins');
    }
}
