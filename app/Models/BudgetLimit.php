<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetLimit extends Model
{

    protected $table = 'budget_limits';
    public $timestamps = true;
    protected $fillable = array('category_id', 'amount', 'department_id');

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
