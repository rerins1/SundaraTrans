<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('biodatas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->string('email');
            $table->string('no_handphone');
            $table->text('alamat');
            $table->string('nama_penumpang');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('biodatas');
    }
};