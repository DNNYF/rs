<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKamarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kamar')->unique();
            $table->string('tipe_kamar');
            $table->unsignedBigInteger('pasien_id')->nullable();
            $table->unsignedBigInteger('dokter_jaga_id')->nullable();
            $table->unsignedBigInteger('dokter_spesialis_id')->nullable();
            $table->unsignedBigInteger('perawat_id')->nullable();
            $table->enum('status', ['kosong', 'terisi'])->default('kosong');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('set null');
            $table->foreign('dokter_jaga_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('dokter_spesialis_id')->references('id')->on('dokters')->onDelete('set null');
            $table->foreign('perawat_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kamars');
    }
}
