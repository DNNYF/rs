<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar');
            $table->string('tipe_kamar');
            $table->string('penghuni_kamar')->nullable(); // Add room occupant
            $table->string('dokter_jaga')->nullable(); // Add on-duty doctor
            $table->string('dokter_spesialis')->nullable(); // Add specialist doctor
            $table->string('perawat')->nullable(); // Add nurse
            $table->enum('status', ['kosong', 'terisi'])->default('kosong');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
