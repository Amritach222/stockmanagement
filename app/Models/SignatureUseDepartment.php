<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignatureUseDepartment extends Model
{

    protected $table = 'signature_use_departments';
    public $timestamps = true;
    protected $fillable = array('department_id', 'signature_id');

    public function signature()
    {
        return $this->belongsTo(Signature::class, 'signature_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
