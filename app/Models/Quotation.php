<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{

    protected $table = 'quotations';
    public $timestamps = true;
    protected $fillable = array('reference_no', 'user_id', 'department_id', 'file_id', 'status', 'note', 'reviewed_by', 'approved_by', 'due_date', 'desired_delivery_date', 'requested_name','is_from_purchase');

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
        $vendorQuotation = VendorQuotation::where('quotation_id', $this->id)->where('vendor_id', $vendor_id)->first();
        $status = $vendorQuotation->status;
        return $status;
    }

    public function getProductStatus($id)
    {
        $quotationProduct = QuotationProduct::findOrFail($id);
        $vendorQuotationProducts = VendorQuotationProduct::where('quotation_product_id', $quotationProduct->id)->get();
        $accepted_count = 0;
        $approved_count = 0;
        $rejected_count = 0;
        $cancelled_count = 0;
        $onprogress_count = 0;
        $pending_count = 0;
        $status = '';
        foreach ($vendorQuotationProducts as $vendorQuotation) {
            if ($vendorQuotation->status == 'Accepted') {
                $accepted_count = $accepted_count + 1;
            } elseif ($vendorQuotation->status == 'Rejected') {
                $rejected_count = $rejected_count + 1;
            } elseif ($vendorQuotation->status == 'Pending') {
                $pending_count = $pending_count + 1;
            } elseif ($vendorQuotation->status == 'On Progress') {
                $onprogress_count = $onprogress_count + 1;
            } elseif ($vendorQuotation->status == 'Approved') {
                $approved_count = $approved_count + 1;
            } elseif ($vendorQuotation->status == 'Cancelled') {
                $cancelled_count = $cancelled_count + 1;
            } else {
                $status = $vendorQuotation->status;
            }
        }
        if (($pending_count > 0) && ($pending_count == count($vendorQuotationProducts))) {
            return "Pending";
        } elseif (($approved_count > 0) && ($approved_count <= count($vendorQuotationProducts))) {
            return "Approved";
        } elseif (($onprogress_count > 0) && ($onprogress_count <= count($vendorQuotationProducts))) {
            return "On Progress";
        } elseif (($accepted_count > 0) && ($accepted_count <= count($vendorQuotationProducts))) {
            return "On Progress";
        } elseif (($rejected_count > 0) && ($rejected_count == count($vendorQuotationProducts))) {
            return "Rejected";
        } elseif (($cancelled_count > 0) && ($cancelled_count == count($vendorQuotationProducts))) {
            return "Cancelled";
        } else {
            return $status;
        }
    }

    public function isPending()
    {
        $pending_count = 0;
        $quotationProductIds = QuotationProduct::where('quotation_id', $this->id)->pluck('id');
        foreach ($quotationProductIds as $id) {
            if ($this->getProductStatus($id) === 'Pending') {
                $pending_count = $pending_count + 1;
            }
        }
        if (($pending_count > 0) && ($pending_count == count($quotationProductIds))) {
            return true;
        } else {
            return false;
        }
    }
}
