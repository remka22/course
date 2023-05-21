<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_client');
            $table->string('mark');
            $table->string('model');
            $table->string('gos_number');

            $table->foreign('id_client')->references('id')->on('client');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
