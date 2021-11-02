<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{

    protected $table = 'budgets';
    public $timestamps = true;
    protected $fillable = array('department_id', 'fiscal_year_id', 'allocated_budget_amount', 'initial_dispatched_amount', 'final_dispatched_amount', 'date_first_received', 'remarks', 'file_ids');

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }
}
