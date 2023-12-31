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
        Schema::create('manual_bot_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('bot_auto_follow')->default(false);
            $table->boolean('bot_auto_like')->default(false);
            $table->boolean('bot_auto_comment')->default(false);
            $table->boolean('bot_auto_seen_like')->default(false);
            $table->string('input_target');
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
            $table->string('delay');
            $table->string('status');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manual_bot_histories');
    }
};
