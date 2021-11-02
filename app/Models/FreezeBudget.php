<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreezeBudget extends Model
{

    protected $table = 'freeze_budgets';
    public $timestamps = true;
    protected $fillable = array('department_id', 'fiscal_year_id', 'amount', 'remark');

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }
}
