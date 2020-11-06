<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVisit extends Model
{
    protected $table = "products_visits";
    protected $fillable = ['ip_address','user_agent','product_id','date'];

    public $timestamps = false;
}
