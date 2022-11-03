<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_section', function (Blueprint $table) {
            $table->string('item_id');
            $table
                ->foreign('item_id')
                ->references('id')
                ->on('items');
            $table->string('section_id');
            $table
                ->foreign('section_id')
                ->references('id')
                ->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_section');
    }
}
