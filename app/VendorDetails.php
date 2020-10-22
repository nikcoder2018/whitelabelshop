<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorDetails extends Model
{
    protected $table = "vendors_details";
    protected $fillable = ['vendor_id', 'vat', 'address', 'region', 'city', 'phone', 'contact_person_name','contact_person_number','subscription'];

    function vendor(){
        return $this->belongsTo(Vendor::class, 'id', 'vendor_id');
    }
}
