<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnusedProduct extends Model
{

    protected $table = 'unused_products';
    public $timestamps = true;
    protected $fillable = array('code', 'item_id', 'department_id', 'user_id', 'approved_by', 'image_id', 'note');

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
