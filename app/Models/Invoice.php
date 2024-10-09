<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pasien',
        'total_tagihan',
    ];

    // Relasi dengan InvoiceObat (One to Many)
    public function invoiceObat()
    {
        return $this->hasMany(InvoiceObat::class);
    }
}
