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
        Schema::create('locations', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->json('name')->nullable();
            $table->json('title')->nullable();
            $table->integer('floor')->nullable();
            $table->string('building')->nullable();
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->string('location_id')->nullable();
            $table
                ->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->nullOnDelete();
        });
        Schema::table('sections', function (Blueprint $table) {
            $table->string('location_id')->nullable();
            $table
                ->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->nullOnDelete();
        });
        Schema::table('places', function (Blueprint $table) {
            $table->string('location_id')->nullable();
            $table
                ->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn('location_id');
        });
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('location_id');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('location_id');
        });

        Schema::dropIfExists('locations');
    }
};
