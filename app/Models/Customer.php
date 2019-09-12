<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'email', 'name', 'address', 'phone'
    ];

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
