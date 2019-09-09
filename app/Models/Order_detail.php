<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'qty', 'price'
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
