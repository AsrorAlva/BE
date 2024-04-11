<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels';
    protected $primaryKey = 'id_hotels';

    protected $fillable = ['nama_hotel', 'kota', 'alamat', 'harga', 'rating', 'gambar',];

    public function pakets()
    {
        return $this->hasMany(PaketModel::class, 'id_hotels');
    }
}
