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
        Schema::create('rawat_jalans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->unsignedBigInteger('dokter_id');
            $table->enum('step', ['step1', 'step2', 'step3']);
            $table->decimal('biaya', 10, 2);
            $table->timestamps();
        
            $table->foreign('pasien_id')->references('id')->on('pasiens');
            $table->foreign('dokter_id')->references('id')->on('dokters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
