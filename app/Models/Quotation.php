<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{

    protected $table = 'quotations';
    public $timestamps = true;
    protected $fillable = array('reference_no', 'user_id', 'department_id', 'file_id', 'status', 'note', 'reviewed_by', 'approved_by', 'due_date', 'desired_delivery_date', 'requested_name');

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

    public function getVendorStatus($vendor_id)
    {
        $vendorQuotations = VendorQuotation::where('quotation_id', $this->id)->where('vendor_id', $vendor_id)->get();
        $accepted_count = 0;
        $rejected_count = 0;
        foreach ($vendorQuotations as $vendorQuotation) {
            if ($vendorQuotation->status == 'Accepted') {
                $accepted_count = $accepted_count + 1;
            } elseif ($vendorQuotation->status == 'Rejected') {
                $rejected_count = $rejected_count + 1;
            } elseif ($vendorQuotation->status == 'Pending') {
                return "Pending";
            } elseif ($vendorQuotation->status == 'On Progress') {
                return "On Progress";
            }
        }
        if (($accepted_count > 0) && ($accepted_count == count($vendorQuotations))) {
            return "Accepted";
        } elseif (($accepted_count > 0) && ($accepted_count < count($vendorQuotations))) {
            return "Partially Accepted";
        } elseif (($rejected_count > 0) && ($rejected_count == count($vendorQuotations))) {
            return "Rejected";
        }
    }

    public function getProductStatus($product_id)
    {
        $quotationProductIds = QuotationProduct::where('quotation_id', $this->id)->where('product_id', $product_id)->pluck('id');
        $vendorQuotationProducts = VendorQuotationProduct::whereIn('quotation_product_id', $quotationProductIds)->get();
        $accepted_count = 0;
        $rejected_count = 0;
        foreach ($vendorQuotationProducts as $vendorQuotation) {
            if ($vendorQuotation->status == 'Accepted') {
                $accepted_count = $accepted_count + 1;
            } elseif ($vendorQuotation->status == 'Rejected') {
                $rejected_count = $rejected_count + 1;
            } elseif ($vendorQuotation->status == 'Pending') {
                return "Pending";
            } elseif ($vendorQuotation->status == 'On Progress') {
                return "On Progress";
            }
        }
        if (($accepted_count > 0) && ($accepted_count == count($vendorQuotationProducts))) {
            return "Accepted";
        } elseif (($accepted_count > 0) && ($accepted_count < count($vendorQuotationProducts))) {
            return "Partially Accepted";
        } elseif (($rejected_count > 0) && ($rejected_count == count($vendorQuotationProducts))) {
            return "Rejected";
        }
    }
}
