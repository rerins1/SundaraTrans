<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id(); // ID bus
            $table->string('kode_bus');
            $table->string('no_polisi');
            $table->integer('kapasitas');
            $table->enum('status', ['Tersedia', 'Tidak Tersedia']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buses');
    }
};