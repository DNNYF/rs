<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceObat extends Model
{
    use HasFactory;

    protected $table = 'invoice_obat';

    protected $fillable = [
        'invoice_id',
        'medicine_name',
        'quantity',
        'price',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
