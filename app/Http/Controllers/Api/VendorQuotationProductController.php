<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorQuotationProductResource;
use App\Models\Tax;
use App\Models\VendorQuotation;
use App\Models\VendorQuotationProduct;
use Illuminate\Http\Request;

class VendorQuotationProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\VendorQuotationProduct $vendorQuotationProduct
     * @return \Illuminate\Http\Response
     */
    public function show(VendorQuotationProduct $vendorQuotationProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\VendorQuotationProduct $vendorQuotationProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorQuotationProduct $vendorQuotationProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VendorQuotationProduct $vendorQuotationProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $vendorQuotationProduct = VendorQuotationProduct::findOrFail($id);
            $values = $request->all();

            $discount = 0;
            if ($request->discount !== null) {
                if ($request->discount_type == 'Percent') {
                    $discount = ($request->price * $request->quantity) * ($request->discount / 100);
                } else {
                    $discount = $request->discount ?? 0;
                }
            }
            $taxValue = 0;
            if (($request->tax_id !== null) && ($request->tax_id != '')) {
                $tax = Tax::findOrFail($request->tax_id);
                $taxValue = ($tax->value / 100) * $request->quantity * $request->price;
            }
            $values['total'] = $request->price * $request->quantity + $request->shipping_cost - $discount + $taxValue;
            $vendorQuotationProduct->update($values);
            $vendorQuotation = VendorQuotation::findOrFail($vendorQuotationProduct->vendor_quotation_id);
            $vendorQuotation->calculateTotal();
            $data['message'] = 'Updated successfully.';
            $data['data'] = new VendorQuotationProductResource($vendorQuotationProduct);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\VendorQuotationProduct $vendorQuotationProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorQuotationProduct $vendorQuotationProduct)
    {
        //
    }
}
