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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('kelas');  // Kelas bus
            $table->string('kode');   // Kode bus
            $table->date('tanggal');    // Waktu keberangkatan tanggal
            $table->time('waktu');    // Waktu keberangkatan (jam)
            $table->string('dari');   // Kota asal
            $table->string('tujuan'); // Kota tujuan
            $table->integer('kursi'); // Jumlah kursi tersedia
            $table->decimal('harga', 10, 2); // Harga tiket
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};


