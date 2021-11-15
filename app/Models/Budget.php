<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{

    protected $table = 'budgets';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function dispatchedAmounts()
    {
        return $this->hasMany(BudgetDispatch::class, 'budget_id');
    }
}
