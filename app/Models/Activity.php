<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    protected $table = 'activities';
    public $timestamps = true;
    protected $fillable = array('name');

    public function logs()
    {
        return $this->hasMany(Log::class, 'activity_id');
    }
}
