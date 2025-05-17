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
        Schema::create('transaksi_minumans', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi_minuman');
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_minuman');
            $table->integer('jumlah');
            $table->integer('total');
            $table->timestamps();
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksis')->onDelete('cascade');
            $table->foreign('id_minuman')->references('id_minuman')->on('minumans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_minumans');
    }
};
