<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'product_id',
        'customer_id',
        'customer_name',
        'slug',
        'customer_email',
        'shipping_address',
        'no_hp',
        'catatan',
        'jenis_pembayaran',
        'total_amount',
        'status',
    ];

    public function orderItems(){
        return $this->hasMany(Order_item::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute()
{
    return \Carbon\Carbon::parse($this->attributes['created_at'])->setTimezone('Asia/Jakarta')
       ->format('d, M Y H:i');
}

public function product(){
    return $this->hasMany(Product::class);
}

public function getRouteKeyName()
    {
        return 'slug';
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'order_id');
    }

    public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}
}
