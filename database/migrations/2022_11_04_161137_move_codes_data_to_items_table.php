<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MoveCodesDataToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            'INSERT INTO `items` (`id`, `airtable_id`, `offset_top`, `description`, `author_name`, `author_description`) ' .
                'SELECT `item_id`, `airtable_id`, `offset_top`, `description`, `author_name`, `author_description` FROM `codes`'
        );

        Schema::table('codes', function (Blueprint $table) {
            $table->string('codeable_type');
            $table->renameColumn('item_id', 'codeable_id');
            $table->dropColumn(['airtable_id', 'offset_top', 'description', 'author_name', 'author_description']);
        });

        DB::table('codes')->update(['codeable_type' => 'item']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('codes', function (Blueprint $table) {
            $table->string('item_id')->nullable();
            $table->integer('offset_top')->default(0);
            $table->json('description')->nullable();
            $table->json('author_name')->nullable();
            $table->json('author_description')->nullable();
            $table->renameColumn('codeable_id', 'airtable_id');
            $table->dropColumn('codeable_type');
        });

        DB::table('codes', 'c')
            ->join('items as i', 'c.codeable_id', '=', 'i.id')
            ->update([
                'c.airtable_id' => DB::raw('i.airtable_id'),
                'c.offset_top' => DB::raw('i.offset_top'),
                'c.description' => DB::raw('i.description'),
                'c.author_name' => DB::raw('i.author_name'),
                'c.author_description' => DB::raw('i.author_description'),
            ]);

        Schema::table('codes', function (Blueprint $table) {
            $table
                ->string('item_id')
                ->nullable(false)
                ->change();
        });

        DB::table('items')->delete();
    }
}
