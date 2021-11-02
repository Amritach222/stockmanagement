<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model 
{

    protected $table = 'sms_settings';
    public $timestamps = true;
    protected $fillable = array('gateway', 'api_key');

}