<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDokter extends Model
{
    use HasFactory;

    protected $table = 'invoice_dokter';

    protected $fillable = [
        'invoice_id',
        'nama_dokter',
        'biaya_pelayanan',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
