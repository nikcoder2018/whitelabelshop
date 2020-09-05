<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $fillable = ['user_id', 'title', 'description', 'slug', 'regular_price', 'sale_price', 'stock_availability', 'image_url'];

    function vendor(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    function categories(){
        return $this->hasMany(ProductCategory::class);
    }

    function tags(){
        return $this->hasMany(ProductTag::class);
    }
}
