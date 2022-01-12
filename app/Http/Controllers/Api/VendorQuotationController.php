<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorQuotationRequest;
use App\Http\Resources\VendorQuotation as VendorQuotationResource;
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
            $vendorQuotation = new VendorQuotation($values);
            $vendorQuotation->save();
            $data['data'] = new VendorQuotationResource($vendorQuotation);
            event(new ActivityLogEvent('Add', 'Vendor Quotation', $data['data']->id));
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
