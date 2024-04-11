<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paket2Model extends Model
{
    use HasFactory;
    protected $table = 'paket2';
    protected $primaryKey = 'id_paket2';
    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'destinasi',
        'transportasi',
        'akomodasi',
        'harga_paket',
        'fasilitas',
        'kuliner',
        'image',
        'rating'
        
    ];
}
