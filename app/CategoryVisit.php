<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryVisit extends Model
{
    protected $table = "categories_visits";
    protected $fillable = ['ip_address','user_agent','category_id','date'];

    public $timestamps = false;
}
