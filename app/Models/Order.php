<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice', 'customer_id', 'user_id', 'total'
    ];

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function order_detail()
    {
        return $this->belongsTo(Order_detail::class);
    }
}
