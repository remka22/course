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
        Schema::create('data_time', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_record')->nullable();
            $table->string('date');
            $table->boolean('status');

            $table->foreign('id_record')->references('id')->on('record_apointment');
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
