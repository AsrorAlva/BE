<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class foodModel extends Model
{
    use HasFactory;

    protected $table = 'food';

    protected $primaryKey = 'id_food';

    protected $fillable = ['alamat', 'nama_kuliner', 'rating', 'keterangan', 'kota', 'tutup',];

    public function pakets()
    {
        return $this->hasMany(PaketModel::class, 'id_food');
    }
}
