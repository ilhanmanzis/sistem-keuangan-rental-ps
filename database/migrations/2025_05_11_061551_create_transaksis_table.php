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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi');
            $table->unsignedBigInteger('id_user');
            $table->string('kode_member')->nullable();
            $table->unsignedBigInteger('id_device')->nullable();;
            $table->unsignedBigInteger('id_shift');
            $table->string('name')->nullable();
            $table->string('no_telpon')->nullable();
            $table->date('tanggal');
            $table->integer('durasi_jam')->nullable();
            $table->integer('bonus_jam')->default(0);
            $table->integer('total_device')->nullable();
            $table->integer('total_makanan')->nullable();
            $table->integer('total_minuman')->nullable();
            $table->integer('total');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('kode_member')->references('kode_member')->on('members');
            $table->foreign('id_device')->references('id_device')->on('devices');
            $table->foreign('id_shift')->references('id_shift')->on('shifts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
