<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pelanggan',
        'email',
        'telepon',
        'jenis_kelamin',
        'alamat'
    ];
}
