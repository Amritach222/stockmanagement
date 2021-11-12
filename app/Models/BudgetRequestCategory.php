<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetRequestCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function budgetRequest()
    {
        return $this->belongsTo(BudgetRequest::class, 'budget_request_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
