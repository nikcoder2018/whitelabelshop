<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationCity extends Model
{
    protected $table = "location_city";
    protected $fillable = ['country', 'name'];

    public $timestamps = false;
    function country(){
        return $this->hasOne(LocationCountry::class, 'id', 'country')->with('region');
    }
}
