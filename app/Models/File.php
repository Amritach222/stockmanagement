<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $table = 'files';
    public $timestamps = true;
    protected $fillable = array('original_name', 'name', 'type', 'extension', 'role_id', 'path');

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'file_id');
    }
}
