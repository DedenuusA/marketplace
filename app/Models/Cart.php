<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'customer_id',
        'product_id',
        'quantity',
    ];

     public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
     public function product() : BelongsTo {
        return $this->belongsTo(Product::class);
    }

     // Jika menggunakan timestamps
    public $timestamps = true;

    // Jika kolom user_id bukan merupakan metode
    public function getUserIdAttribute()
    {
        return $this->attributes['user_id'];
    }

        public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getCreatedAtAttribute()
{
    return \Carbon\Carbon::parse($this->attributes['created_at'])->setTimezone('Asia/Jakarta')
       ->format('d, M Y H:i');
   
}
}
 