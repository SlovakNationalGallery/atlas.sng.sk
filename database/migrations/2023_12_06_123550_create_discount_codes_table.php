<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodesTable extends Migration
{
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('bucketlist_id')->nullable();
            $table
                ->foreign('bucketlist_id')
                ->references('id')
                ->on('bucketlists')
                ->nullOnDelete();
            $table->string('code')->unique();
            $table->datetime('used_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount_codes');
    }
}
