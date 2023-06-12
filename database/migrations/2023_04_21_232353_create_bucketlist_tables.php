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
        Schema::create('bucketlists', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->json('title')->nullable();
            $table->timestamps();
        });

        Schema::create('bucketlist_item', function (Blueprint $table) {
            $table->string('bucketlist_id');
            $table->string('item_id');
            $table
                ->foreign('bucketlist_id')
                ->references('id')
                ->on('bucketlists')
                ->onDelete('cascade');
            $table
                ->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');
            $table->integer('ord');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bucketlists');
        Schema::dropIfExists('bucketlist_item');
    }
};
