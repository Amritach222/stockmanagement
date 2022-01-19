<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
use App\Models\Quotation;
use App\Models\User;
use App\Models\VendorProduct;
use App\Models\VendorQuotation;
use Illuminate\Http\Request;

class VendorPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:' . 'vendors.products')->only('productList', 'allProducts');
    }

    public function productList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::findOrFail(auth()->user()->id);
            $vendor = $user->vendor;
            $productIds = VendorProduct::where('vendor_id', $vendor->id)->pluck('product_id');
            $data['data'] = ProductResource::collection(Product::whereIn('id', $productIds)->get());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    public function allProducts()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = ProductResource::collection(Product::where('is_active', 1)->get());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function quotationList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::findOrFail(auth()->user()->id);
            $vendor = $user->vendor;
            $quotation_ids = VendorQuotation::where('vendor_id', $vendor->id)->pluck('quotation_id');
            $data['data'] = Quotation::whereIn('id', $quotation_ids)->get();
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
        }
        return $data;
    }

    public function quotationShow($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $quotation = Quotation::findOrFail($id);
            $data['data'] = new \App\Http\Resources\Quotation($quotation);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
        }
        return $data;
    }
}
