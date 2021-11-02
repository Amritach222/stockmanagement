<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    protected $table = 'logs';
    public $timestamps = true;
    protected $fillable = array('user_id', 'activity_id', 'ip');
    protected $appends = ['activity_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function getActivityNameAttribute()
    {
        $id = $this->model_id ? ' #0' . $this->model_id . '.' : '.';
        return $this->user->username . ' ' . $this->activity->name . $id;
    }
}
