<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'slug',
    ];

     public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
