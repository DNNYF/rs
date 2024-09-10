<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rawat_jalan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien_id');
            $table->unsignedBigInteger('dokter_id');
            $table->json('obat_data'); // Store obat and jumlah as JSON
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');
            $table->foreign('dokter_id')->references('id')->on('dokters')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rawat_jalan');
    }
};
