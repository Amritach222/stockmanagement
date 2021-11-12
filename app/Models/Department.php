<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    protected $table = 'departments';
    public $timestamps = true;
    protected $fillable = array('name', 'head_of_department');

    public function signatureUseDepartments()
    {
        return $this->hasMany(SignatureUseDepartment::class, 'department_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'department_id');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class, 'department_id');
    }

    public function budgetRequests()
    {
        return $this->hasMany(BudgetRequest::class, 'department_id');
    }

    public function consumes()
    {
        return $this->hasMany(Consume::class, 'department_id');
    }

    public function freezeBudgets()
    {
        return $this->hasMany(FreezeBudget::class, 'department_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'department_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'department_id');
    }

    public function fromTransfers()
    {
        return $this->hasMany(Transfer::class, 'from');
    }

    public function toTransfers()
    {
        return $this->hasMany(Transfer::class, 'to');
    }

    public function unusedProducts()
    {
        return $this->hasMany(UnusedProduct::class, 'department_id');
    }

    public function headOfDepartment()
    {
        return $this->belongsTo(User::class, 'head_of_department');
    }

    public function budgetLimits()
    {
        return $this->hasMany(BudgetLimit::class, 'department_id');
    }
}
