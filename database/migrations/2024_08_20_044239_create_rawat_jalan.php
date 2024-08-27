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
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade'); 
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade'); 
            $table->decimal('total_biaya', 10, 2); 
            $table->enum('step', ['step1', 'step2', 'step3']); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rawat_jalans');
    }
};
