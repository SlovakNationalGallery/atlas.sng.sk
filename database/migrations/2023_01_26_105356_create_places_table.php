<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->json('video_title')->nullable();
            $table->json('video_subtitle')->nullable();
            $table->json('video')->nullable();
            $table->integer('offset_top')->default(0);
            $table->string('story_id')->nullable();
            $table->foreign('story_id')->references('id')->on('stories');
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
        Schema::dropIfExists('places');
    }
};
