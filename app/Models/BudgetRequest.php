<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetRequest extends Model
{

    protected $table = 'budget_requests';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function budgetRequestCategories()
    {
        return $this->hasMany(BudgetRequestCategory::class, 'budget_request_id');
    }
}
