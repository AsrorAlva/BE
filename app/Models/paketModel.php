<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paketModel extends Model
{
    use HasFactory;

    protected $table = 'paket';

    protected $primaryKey = 'id_paket';

    protected $fillable = ['nama_paket', 'deskripsi', 'harga_paket', 'tanggal_berangkat', 'tanggal_pulang', 'durasi', 'lokasi_bernagkat', 'lokasi_tujuan', 'id_hotels', 'id_transportasi', 'id_destinasi', ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotels');
    }

    public function destinasi()
    {
        return $this->belongsTo(destinasiModel::class, 'id_destinasi');
    }

    public function transportasi()
    {
        return $this->belongsTo(transportModel::class, 'id_transportasi');
    }
}
