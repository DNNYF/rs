<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vod extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'file_path', 'thumbnail_path'];
}
