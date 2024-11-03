<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranTable extends Migration
{
    public function up()
    {
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->string('id_pengeluaran', 225)->primary();
            $table->string('id_kategori', 225);
            $table->string('id_user', 225);
            $table->string('bukti', 225);
            $table->dateTime('tanggal');
            $table->integer('nominal');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori');
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengeluaran');
    }
}

