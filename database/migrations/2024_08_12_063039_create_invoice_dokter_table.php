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
        Schema::create('invoice_dokter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id'); // Foreign key to invoices table
            $table->string('nama_dokter');
            $table->decimal('biaya_pelayanan', 15, 2); // Service fee with 2 decimal places
            $table->timestamps();

            // Foreign key constraint
            $table  ->foreign('invoice_id')
                    ->references('id')->on('invoices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_dokter');
    }
};
