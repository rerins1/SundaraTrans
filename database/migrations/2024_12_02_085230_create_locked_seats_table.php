<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLockedSeatsTable extends Migration
{
    public function up()
    {
        Schema::create('locked_seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id'); // Harus numerik dan cocok dengan id di tabel tickets
            $table->string('seat_number');
            $table->timestamp('locked_until');
            $table->timestamp('expired_at')->nullable();
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('locked_seats');
    }
}
