<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorNameToCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('codes', function (Blueprint $table) {
            $table->json('author_name')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('codes', function (Blueprint $table) {
            $table->dropColumn('author_name');
        });
    }
}
