<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneView extends Model
{
    protected $table = "phone_views";
    protected $fillable = ['ip_address','user_agent','vendor_id','date'];

    public $timestamps = false;
}
