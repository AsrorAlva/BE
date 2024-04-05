<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agen extends Model
{
    protected $table = 'agen'; // Sesuaikan nama tabel dengan yang benar
    protected $primaryKey = 'id_agen';
    protected $fillable = [
        "name",
        "username",
        "password"
    ];
}
