<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorProfile extends Model
{
    protected $table = "vendors_profile";
    protected $fillable = ['vendor_id', 'avatar', 'delivery', 'about', 'facebook', 'instagram', 'twitter', 'website', 'address','phone', 'contact_person_name','contact_person_number','subscription'];

    public $timestamps = false;

    function vendor(){
        return $this->belongsTo(Vendor::class, 'id', 'vendor_id');
    }
}
