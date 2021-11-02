<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPasswordRequest extends Model
{

    protected $table = 'reset_password_requests';
    public $timestamps = true;
    protected $fillable = array('user_id', 'reset_by', 'reset_on', 'status');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reset()
    {
        return $this->belongsTo(User::class, 'reset_by');
    }
}
