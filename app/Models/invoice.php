<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'nama_pasien',
        'total_tagihan',
    ];

    public function medicines()
    {
        return $this->hasMany(InvoiceObat::class, 'invoice_id');
    }
    
    public function doctors()
    {
        return $this->hasMany(InvoiceDokter::class, 'invoice_id');
    }
}

