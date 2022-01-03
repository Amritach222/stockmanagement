<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Request;

class VendorPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:' . 'vendors.products')->only('productList');
    }

    public function productList()
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
}
