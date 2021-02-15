<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "settings";
    protected $fillable = ['name','value'];

    public $timestamps = false;

    public static function getv($key)
    {
        return static::where('key', $key)->first()->value;
    }
    public static function get($key)
    {
        return static::where('key', $key)->first();
    }
    public static function set($key, $value)
    {
        $setting = static::get($key);
        if (!$setting) {
            $setting = new static([
                'key' => $value,
            ]);
        }
        $setting->value = $value;
        $setting->save();
        return $setting;
    }
}
