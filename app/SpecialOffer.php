<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected $table = "special_offers";
    protected $fillable = ['user_id', 'title', 'description', 'image', 'date_start', 'date_end', 'time_start', 'time_end', 'price', 'status'];

    function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
