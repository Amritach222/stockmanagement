<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetExtend extends Model
{

//    protected $table = 'budget_extends';
    public $timestamps = true;
    protected $fillable = array('department_id', 'amount', 'remarks', 'file_id', 'status', 'approved_by');

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
