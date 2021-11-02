<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{

    protected $table = 'mail_settings';
    public $timestamps = true;
    protected $fillable = array('mail_host', 'mail_port', 'mail_address', 'password', 'mail_from_name', 'encryption');

}
