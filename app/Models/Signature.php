<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{

    protected $table = 'signatures';
    public $timestamps = true;
    protected $fillable = array('file_id', 'user_id', 'designation_id');

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function signatureUseDepartments()
    {
        return $this->hasMany(SignatureUseDepartment::class, 'signature_id');
    }
}
