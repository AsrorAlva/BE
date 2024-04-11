<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class destinasiModel extends Model
{
    use HasFactory;
    protected $table = 'destinasi';

    protected $primaryKey = 'id_destinasi';

    protected $fillable = ['nama_destinasi', 'alamat', 'pulau', 'rating', 'keterangan',];

    public function pakets()
    {
        return $this->hasMany(PaketModel::class, 'id_destinasi');
    }
}
