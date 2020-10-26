<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationRegion extends Model
{
    protected $table = "location_region";
    protected $fillable = ['name'];

    public $timestamps = false;

    function countries(){
        return $this->hasMany(LocationCountry::class, 'region', 'id')->with('cities');
    }

}
