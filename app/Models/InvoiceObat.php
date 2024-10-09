<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceObat extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'nama_obat',
        'quantity',
        'price',
    ];

    // Relasi dengan Invoice (Many to One)
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
