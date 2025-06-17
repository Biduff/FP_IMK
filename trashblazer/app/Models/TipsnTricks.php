<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipsnTricks extends Model
{
    use HasFactory;

    protected $table = 'tipsntricks';

    protected $fillable = [
        'judul',
        'gambar',
        'alat_dan_bahan',
        'langkah_langkah'
    ];
}