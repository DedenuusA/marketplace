<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function review()
{
    return $this->hasOne(review::class);
}

}
