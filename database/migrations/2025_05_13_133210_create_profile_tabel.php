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
        Schema::create('profile', function (Blueprint $table) {
            $table->bigIncrements('profile_id');
            $table->string('name');
            $table->string('logo');
            $table->string('alamat');
            $table->string('no_telpon');
            $table->integer('minimal')->nullable();
            $table->integer('bonus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_tabel');
    }
};
