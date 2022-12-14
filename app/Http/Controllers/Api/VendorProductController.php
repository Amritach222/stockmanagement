<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorProduct;
use Illuminate\Http\Request;

class VendorProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type, $id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $arrayData = [];
            if ($type == 'product') {
                if (auth()->user()->isVendor()) {
                    $user = User::findOrFail($id);
                    $vendor = $user->vendor;
                } else {
                    $vendor = Vendor::findOrFail($id);
                }
                $vendorProducts = VendorProduct::where('vendor_id', $vendor->id)->get();
                foreach ($vendorProducts as $k => $vendorProduct) {
                    $arrayData[$k]['id'] = $vendorProduct->id;
                    $arrayData[$k]['product_id'] = $vendorProduct->product_id;
                    $arrayData[$k]['status'] = $vendorProduct->status;
                }
            } else {
                $product = Product::findOrFail($id);
                $vendorProducts = VendorProduct::where('product_id', $product->id)->get();
                foreach ($vendorProducts as $k => $vendorProduct) {
                    $arrayData[$k]['id'] = $vendorProduct->id;
                    $arrayData[$k]['vendor_id'] = $vendorProduct->vendor_id;
                    $arrayData[$k]['status'] = $vendorProduct->status;
                }
            }
            $data['data'] = $arrayData;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
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
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            if (auth()->user()->isVendor()) {
                $user = User::findOrFail($request->id);
                $vendor = $user->vendor;
                $values['status'] = 'Pending';
            } else {
                $vendor = Vendor::findOrFail($request->id);
                $values['status'] = 'Verified';
            }
            $requestProductIds = json_decode($request->product_ids);
            $product_ids = VendorProduct::where('vendor_id', $vendor->id)->pluck('product_id');
            $values['vendor_id'] = $vendor->id;
            foreach ($requestProductIds as $id) {
                if (!$product_ids->contains($id)) {
                    $values['product_id'] = $id;
                    $vendorProduct = new VendorProduct($values);
                    $vendorProduct->save();
                } else {
                    $vendorProduct = VendorProduct::where('vendor_id', $vendor->id)->where('product_id', $id)->firstOrFail();
                    if (($vendorProduct->status == 'Unverified') or ($vendorProduct->status == 'Pending')) {
                        $vendorProduct->status = $values['status'];
                        $vendorProduct->save();
                    }
                }
            }
            foreach ($product_ids as $pid) {
                if (!in_array($pid, $requestProductIds)) {
                    $vP = VendorProduct::where('vendor_id', $vendor->id)->where('product_id', $pid)->first();
                    if (auth()->user()->isVendor()) {
                        $vP->delete();
                    }
                }
            }

            $data['data'] = $vendor->vendorProducts;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\VendorProduct $vendorProduct
     * @return \Illuminate\Http\Response
     */
    public function show(VendorProduct $vendorProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\VendorProduct $vendorProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorProduct $vendorProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\VendorProduct $vendorProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendorProduct $vendorProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\VendorProduct $vendorProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorProduct $vendorProduct)
    {
        //
    }

    public function statusUpdate($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $vendorProduct = VendorProduct::findOrFail($id);
            $vendorProduct->status = $request->status;
            $vendorProduct->save();
//            } else {
//                $vendorProduct->delete();
//            }
            $data['message'] = "Status changed successfully.";
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
            $data['data'] = $e;
        }
        return $data;
    }
}
