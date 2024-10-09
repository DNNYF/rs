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
        Schema::create('rawat_jalan_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained();
            $table->foreignId('dokter_id')->constrained();
            $table->text('obat_list')->nullable();
            $table->enum('step',['1','2','3'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rawat_jalan_sessions');
    }
};
