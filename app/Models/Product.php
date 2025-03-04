<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'toko_id',
        'nama_product',
        'slug',
        'deskripsi',
        'harga',
        'diskon',
        'kondisi',
        'image',
        'warna',
        'stok',
        'whatsapp_number',
    ];

     public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

     public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

     public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function orderItem(){
        return $this->hasMany(Order_item::class);
    }

    public function reviews(){
        return $this->hasMany(review::class);
    }

    public function order()
{
    return $this->hasMany(Order::class);
}

public function getRouteKeyName()
    {
        return 'slug';
    }

    public function review(){
        return $this->belongsTo(review::class);
    }

}
