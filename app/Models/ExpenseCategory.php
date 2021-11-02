<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{

    protected $table = 'expense_categories';
    public $timestamps = true;
    protected $fillable = array('name', 'code', 'is_active');

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_category_id');
    }
}
