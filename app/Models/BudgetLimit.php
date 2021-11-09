<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetLimit extends Model
{

    protected $table = 'budget_limits';
    public $timestamps = true;
    protected $fillable = array('category_id', 'amount');

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
