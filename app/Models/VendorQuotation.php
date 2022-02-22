<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorQuotation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function vendorQuotationProducts()
    {
        return $this->hasMany(VendorQuotationProduct::class, 'vendor_quotation_id');
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->vendorQuotationProducts as $vendorQuotationProduct) {
            $total = $total + $vendorQuotationProduct->total;
        }
        $discount = 0;
        if ($this->discount !== null) {
            if ($this->discount_type == 'Percent') {
                $discount = $this->total_price * ($this->discount / 100);
            } else {
                $discount = $this->discount ?? 0;
            }
        }
        $this->total_price = $total;
        $this->grand_total = $this->total_price - $discount;
        $this->save();
    }
}
