<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorQuotationProductResource;
use App\Models\File;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
use App\Models\Quotation;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Models\VendorQuotation;
use App\Models\VendorQuotationProduct;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

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
            $data['data'] = \App\Http\Resources\Vendor\Quotation::collection(Quotation::whereIn('id', $quotation_ids)->get());
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
            $user = User::findOrFail(auth()->user()->id);
            $vendor = $user->vendor;
            $vendorQuotation = VendorQuotation::where('vendor_id', $vendor->id)->where('quotation_id', $quotation->id)->firstOrFail();
            if ($vendorQuotation->status == 'Pending') {
                $vendorQuotation->status = 'On Progress';
                $vendorQuotation->save();
            }
            foreach ($vendorQuotation->vendorQuotationProducts as $product) {
                if ($product->status == 'Pending') {
                    $product->status = 'On Progress';
                    $product->save();
                }
            }
            $data['data'] = new \App\Http\Resources\Vendor\Quotation($quotation);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
        }
        return $data;
    }

    public function quotationUpdate($id, Request $request)
    {
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $vendorQuotation = VendorQuotation::findOrFail($id);
            $values = $request->all();
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'vendorQuotation');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if ($vendorQuotation->file_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $vendorQuotation->file_id)->first();
                    if ($newFile === null) {
                        $newFile = new File();
                    } else {
                        $hasdata = 1;
                        $fileHelper->deleteFile($newFile->path);
                    }
                }

                $newFile->extension = $file['data']['extension'];
                $newFile->original_name = $file['data']['original_filename'];
                $newFile->name = $file['data']['filename'];
                $newFile->type = $file['data']['mime_type'];
                $newFile->path = $file['data']['link'];
                if ($hasdata === 1) {
                    $newFile->update();
                } else {
                    $newFile->save();
                }
                $values['file_id'] = $newFile->id;
            }
            $acceptCount = 0;
            foreach ($vendorQuotation->vendorQuotationProducts as $product) {
                if ($product->status == 'Accepted') {
                    $acceptCount = $acceptCount + 1;
                }
            }
            if ($acceptCount == count($vendorQuotation->vendorQuotationProducts)) {
                if ($vendorQuotation->status == 'On Progress') {
                    $values['status'] = 'Accepted';
                }
            }
            $vendorQuotation->update($values);
//            $data['data'] = new \App\Http\Resources\Vendor\Quotation($vendorQuotation);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
        }
        return $data;
    }

    public function quotationProductUpdate($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $quotationProduct = VendorQuotationProduct::findOrFail($id);
            $values = $request->all();
            $quotationProduct->update($values);
            $data['data'] = new VendorQuotationProductResource($quotationProduct);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function quotationProductStatusUpdate($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $quotationProduct = VendorQuotationProduct::findOrFail($id);
            $values = $request->only('status');
            $quotationProduct->update($values);
            $data['data'] = new VendorQuotationProductResource($quotationProduct);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function quotationStatusUpdate($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $quotation = VendorQuotation::findOrFail($id);
            $values = $request->only('status');
            $quotation->update($values);
            foreach ($quotation->vendorQuotationProducts as $product) {
                $product->update($values);
            }
            $data['message'] = 'Status updated successfully';
            $data['data'] = new \App\Http\Resources\VendorQuotation($quotation);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }
}
