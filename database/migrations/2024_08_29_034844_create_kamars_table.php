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
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar');
            $table->string('tipe_kamar');
            $table->string('penghuni_kamar')->nullable(); // Add room occupant
            $table->string('dokter_jaga')->nullable(); // Add on-duty doctor
            $table->string('dokter_spesialis')->nullable(); // Add specialist doctor
            $table->string('perawat')->nullable(); // Add nurse
            $table->enum('status', ['kosong', 'terisi'])->default('kosong');
            $table->unsignedBigInteger('pasien_id')->nullable(); // Foreign key pasien
            $table->unsignedBigInteger('dokter_jaga_id')->nullable(); // Foreign key dokter jaga
            $table->unsignedBigInteger('dokter_spesialis_id')->nullable(); // Foreign key dokter spesialis
            $table->timestamps();

            // Menambahkan foreign key
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('set null');
            $table->foreign('dokter_jaga_id')->references('id')->on('dokters')->onDelete('set null');
            $table->foreign('dokter_spesialis_id')->references('id')->on('dokters')->onDelete('set null');
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
