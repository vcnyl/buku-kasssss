<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanTable extends Migration
{
    public function up()
    {
        Schema::create('penerimaan', function (Blueprint $table) {
            $table->string('id_penerimaan', 225)->primary();
            $table->string('id_user', 225);
            $table->string('bukti', 225);
            $table->dateTime('tanggal');
            $table->integer('nominal');
            $table->timestamps();
            $table->text('keterangan')->nullable();
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penerimaan');
    }
}
