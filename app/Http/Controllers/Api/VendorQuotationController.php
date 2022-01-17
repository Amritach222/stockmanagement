<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Events\VendorAssignQuoEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorQuotationRequest;
use App\Http\Resources\VendorQuotation as VendorQuotationResource;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Models\VendorQuotation;
use Illuminate\Http\Request;

class VendorQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = VendorQuotationResource::collection(VendorQuotation::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorQuotationRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $values = $request->all();
            $reqProducts = json_decode($request->products);
            $reqVendors = json_decode($request->vendors);
            $vendors = [];
            foreach ($reqVendors as $reqVendor) {
                $vendors[] = Vendor::findOrFail($reqVendor->id);
            }
            $relatedVendors = [];
            foreach ($reqProducts as $reqProduct) {
                $product = Product::findOrFail($reqProduct->product_id);
                $vendor_ids = VendorProduct::where('product_id', $product->id)->pluck('vendor_id');
                $quotation = Quotation::findOrFail($request->quotation_id);
                $quotationProduct = QuotationProduct::where('product_id', $product->id)->where('quotation_id', $quotation->id)->firstOrFail();
                foreach ($vendors as $vendor) {
                    foreach ($vendor_ids as $vendor_id) {
                        if ($vendor->id == $vendor_id) {
                            $vendorQuotation = new VendorQuotation([
                                'vendor_id' => $vendor->id,
                                'quotation_id' => $request->quotation_id,
                                'quotation_product_id' => $quotationProduct->id,
                                'quantity' => $quotationProduct->quantity
                            ]);
                            $vendorQuotation->save();
                            $relatedVendors[] = $vendor;
                            event(new ActivityLogEvent('Add', 'Vendor Quotation', $vendorQuotation->id));
                        }
                    }
                }
            }

            $uniqueVendors = array_unique($relatedVendors);
            foreach ($uniqueVendors as $uniqueVendor) {
                $user = User::findOrFail($uniqueVendor->user_id);
                event(new VendorAssignQuoEvent($user, $quotation));
            }
//            $data['data'] = new VendorQuotationResource($vendorQuotation);

            $data['message'] = "Vendor Quotation added successfully.";
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\VendorQuotation $quotationVariant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $vendorQuotation = VendorQuotation::findOrFail($id);
            $data['data'] = new VendorQuotationResource($vendorQuotation);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\VendorQuotation $quotationVariant
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorQuotation $quotationVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VendorQuotation $quotationVariant
     * @return \Illuminate\Http\Response
     */
    public function update(VendorQuotationRequest $request, $id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $values = $request->all();
            $vendorQuotation = VendorQuotation::findOrFail($id);
            $vendorQuotation->update($values);
            $data['data'] = new VendorQuotationResource($vendorQuotation);
            event(new ActivityLogEvent('Edit', 'Vendor Quotation', $vendorQuotation->id));
            $data['message'] = "Vendor Quotation updated successfully.";
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\VendorQuotation $quotationVariant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $vendorQuotation = VendorQuotation::findOrFail($id);
            $vendorQuotation->delete();
            event(new ActivityLogEvent('Delete', 'Vendor Quotation', $id));
            $data['message'] = 'Vendor Quotation deleted successfully.';
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }
}
