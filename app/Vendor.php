<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = "vendors";
    protected $fillable = [
        'username','vendor_name', 'email', 'password', 'vat', 'vat_sec', 'city', 'country', 'status'
    ];
    function vendor_details(){
        return $this->hasOne(VendorProfile::class, 'vendor_id', 'id');
    }
}
