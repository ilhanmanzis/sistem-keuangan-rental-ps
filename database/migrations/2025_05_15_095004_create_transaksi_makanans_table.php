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
        Schema::create('transaksi_makanans', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi_makanan');
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_makanan');
            $table->integer('jumlah');
            $table->integer('total');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksis')->onDelete('cascade');
            $table->foreign('id_makanan')->references('id_makanan')->on('makanans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_makanans');
    }
};
