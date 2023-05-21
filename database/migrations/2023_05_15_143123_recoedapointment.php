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
        Schema::create('record_apointment', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_client');
            $table->integer('id_car');
            $table->string('datetime');
            $table->string('description');
            $table->tinyInteger('status');

            $table->foreign('id_client')->references('id')->on('client');
            $table->foreign('id_car')->references('id')->on('car');
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
