<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $table = "products_tags";
    protected $fillable = ['product_id', 'tag'];

    public $timestamps = false;

    function product(){
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }
}
