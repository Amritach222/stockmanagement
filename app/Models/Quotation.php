<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{

    protected $table = 'quotations';
    public $timestamps = true;
    protected $fillable = array('reference_no', 'user_id', 'department_id', 'file_id', 'status', 'note', 'reviewed_by', 'approved_by', 'due_date', 'desired_delivery_date');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function quotationProducts()
    {
        return $this->hasMany(QuotationProduct::class, 'quotation_id');
    }

    public function vendorQuotations()
    {
        return $this->hasMany(VendorQuotation::class, 'quotation_id');
    }
}
