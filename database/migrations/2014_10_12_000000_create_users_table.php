<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id_user', 225)->primary();
            $table->string('username', 225)->unique();
            $table->string('password', 225);
            $table->string('nama', 225);
            $table->enum('role', ['superadmin', 'admin']);
            $table->enum('cabang', ['kaliwates', 'tegalbesar'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 225)->nullable();
            $table->string('foto', 225)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

