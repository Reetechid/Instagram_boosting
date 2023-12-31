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
        Schema::create('dummy_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('instagram_user')->nullable();
            $table->string('instagram_password')->nullable();
            $table->string('target_account_1')->nullable();
            $table->string('target_account_2')->nullable();
            $table->string('status')->nullable();
            $table->integer('time_total_bot_used')->nullable();
            $table->string('saved_cookie')->nullable();
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
        Schema::dropIfExists('dummy_users');
    }
};
