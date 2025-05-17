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
        Schema::create('member_rewards', function (Blueprint $table) {
            $table->bigIncrements('id_member_reward');
            $table->string('kode_member');
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->integer('durasi')->default(2);
            $table->timestamp('tanggal_klaim')->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_rewards');
    }
};
