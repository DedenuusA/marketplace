<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'order_id',
        'customer_id',
        'product_id',
        'user_id',
        'rating',
        'review',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id'); // Menghubungkan review dengan order berdasarkan order_id
    }

    public function orderItem()
    {
        return $this->belongsTo(Order_item::class, 'order_item_id');
    }

    public function getCreatedAtAttribute()
{
    return \Carbon\Carbon::parse($this->attributes['created_at'])->setTimezone('Asia/Jakarta')
       ->format('d, M Y H:i');
   
}

public function customer(){
    return $this->belongsTo(Customer::class);
}
}
