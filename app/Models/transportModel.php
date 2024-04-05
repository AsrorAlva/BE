<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transportModel extends Model
{
    use HasFactory;

    protected $table = 'transportasi';
    protected $primaryKey = 'id_transportasi';

    protected $fillable = ['nama_transportasi', 'jenis_transportasi', 'berangkat', 'tujuan', 'harga', 'jam_keberangkatan', 'jam_kedatangan',];
}
