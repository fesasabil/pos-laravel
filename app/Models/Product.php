<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $dates = ['updated_at'];

    protected $guarded = [];

    protected $fillable = [
        'code', 'name', 'description', 'stock', 'price', 'category_id', 'user_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
