<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorDetails extends Model
{
    protected $table = "users_vendors_details";
    protected $fillable = ['user_id','vendor_name', 'vat', 'address', 'region', 'city', 'phone', 'contact_person_name','contact_person_number','subscription'];

    function user(){
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
