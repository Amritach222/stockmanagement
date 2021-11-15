<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetDispatch extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }
}
