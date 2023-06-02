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
        Schema::table('item_section', function (Blueprint $table) {
            $table->dropForeign('item_section_item_id_foreign');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->dropForeign('item_section_section_id_foreign');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_section', function (Blueprint $table) {
            $table->dropForeign('item_section_item_id_foreign');
            $table->foreign('item_id')->references('id')->on('items');
            $table->dropForeign('item_section_section_id_foreign');
            $table->foreign('section_id')->references('id')->on('sections');
        });
    }
};
