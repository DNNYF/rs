<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    // Specify the primary key field
    protected $primaryKey = 'id_obat';

    // If the primary key is not an auto-incrementing integer, you can specify its type:
    // protected $keyType = 'string'; // Uncomment if your primary key is a string

    // If you want to disable the auto-incrementing feature, you can do so:
    // public $incrementing = false;

    // Specify the fillable fields
    protected $fillable = [
        'nama_obat',
        'stok_obat',
        'harga_obat',
    ];
}
