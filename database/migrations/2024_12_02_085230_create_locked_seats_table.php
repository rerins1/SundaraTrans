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
            $table->unsignedBigInteger('ticket_id');
            $table->string('seat_number');
            $table->timestamp('locked_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('ticket_id')
                ->references('id')
                ->on('tickets')
                ->onDelete('cascade');

            $table->unique(['ticket_id', 'seat_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('locked_seats');
    }
}