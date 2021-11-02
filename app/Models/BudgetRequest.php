<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetRequest extends Model
{

    protected $table = 'budget_requests';
    public $timestamps = true;
    protected $fillable = array('department_id', 'request_amount', 'status');

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
