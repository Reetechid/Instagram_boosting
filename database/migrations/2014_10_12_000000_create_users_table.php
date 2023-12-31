<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('instagram_user')->nullable();
            $table->string('instagram_password')->nullable();
            $table->string('cookie_data')->nullable();
            $table->string('user_agent')->nullable();
            $table->dateTime('account_expired')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('status')->nullable();
            $table->string('account_role')->nullable();
            $table->integer('time_total_bot_used')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
