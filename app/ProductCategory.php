<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = "products_category";
    protected $fillable = ['product_id', 'category_id'];

    public $timestamps = false;

    function product(){
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }

    function category(){
        return $this->belongsTo(Category::class, 'id', 'category_id');
    }
}
