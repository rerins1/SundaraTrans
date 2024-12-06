<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking')->unique()->after('id');
            $table->string('nama_pemesan');
            $table->string('email');
            $table->string('no_handphone');
            $table->text('alamat');
            $table->json('nama_penumpang'); // Untuk menyimpan array nama penumpang
            $table->json('kursi'); // Untuk menyimpan array nomor kursi
            $table->unsignedBigInteger('ticket_id'); // Relasi ke tiket
            $table->integer('jumlah_penumpang');
            $table->decimal('total_pembayaran', 10, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending')->after('total_pembayaran');
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
