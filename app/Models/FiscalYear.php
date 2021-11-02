<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{

    protected $table = 'fiscal_years';
    public $timestamps = true;
    protected $fillable = array('from', 'to');

    public function budgets()
    {
        return $this->hasMany(Budget::class, 'fiscal_year_id');
    }

    public function freezeBudgets()
    {
        return $this->hasMany(FreezeBudget::class, 'fiscal_year_id');
    }

    public function setting()
    {
        return $this->hasOne(Setting::class, 'fiscal_year_id');
    }
}
