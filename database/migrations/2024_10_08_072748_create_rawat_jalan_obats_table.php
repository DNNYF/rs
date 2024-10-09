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
    Schema::create('rawat_jalan_obats', function (Blueprint $table) {
        $table->id();
        $table->foreignId('rawat_jalan_id')->constrained();
        $table->foreignId('obat_id')->constrained('obats', 'id_obat');
        $table->integer('jumlah');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rawat_jalan_obats');
    }
};
