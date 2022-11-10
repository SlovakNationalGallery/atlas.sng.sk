<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoryStoryLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('story_story_link', function (Blueprint $table) {
            $table->string('story_id');
            $table->string('story_link_id');
            $table
                ->foreign('story_id')
                ->references('id')
                ->on('stories')
                ->cascadeOnDelete();
            $table
                ->foreign('story_link_id')
                ->references('id')
                ->on('story_links')
                ->cascadeOnDelete();
            $table->integer('ord');
            $table->unique(['story_id', 'story_link_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('story_story_link');
    }
}
