<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Toko extends Model
{ 
    protected $table = "tokos";
    protected $primaryKey = 'id';
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'nama_toko',
        'alamat',
        'no_telepon',
        'email',
        'nama_owner',
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

}
