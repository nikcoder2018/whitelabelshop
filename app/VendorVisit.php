<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorVisit extends Model
{
    protected $table = "vendors_visits";
    protected $fillable = ['ip_address','user_agent','vendor_id','date'];

    public $timestamps = false;
}
