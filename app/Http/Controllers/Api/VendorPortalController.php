<?php

namespace App\Http\Controllers\Api;

use App\Events\POVendorEvent;
use App\Events\QuotationStatusChangeEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuotationProduct;
use App\Http\Resources\RegisterPaymentResource;
use App\Http\Resources\VendorQuotationProductResource;
use App\Listeners\QuotationStatusChangeListener;
use App\Models\File;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\RegisterPayment;
use App\Models\Tax;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Models\VendorQuotation;
use App\Models\VendorQuotationProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class VendorPortalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:' . 'vendors.products')->only('productList', 'allProducts');
    }

    public function getVendorData()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::findOrFail(auth()->user()->id);
            $vendor = Vendor::where('user_id', $user->id)->firstOrFail();
            $data['data'] = new \App\Http\Resources\Vendor($vendor);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
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
            $products = Product::whereIn('id', $productIds)->get();
            foreach ($products as $product) {
                $vendorProduct = VendorProduct::where('vendor_id', $vendor->id)->where('product_id', $product->id)->firstOrFail();
                $product->vendor_status = $vendorProduct->status;
            }
            $data['data'] = ProductResource::collection($products);
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
            if ($quotation->status == 'Pending') {
                $quotation->status = 'Reviewed';
                $quotation->save();
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
            if ($vendorQuotation->status == 'On Progress') {
                if ($acceptCount == count($vendorQuotation->vendorQuotationProducts)) {
                    $values['status'] = 'Accepted';
                } elseif (($acceptCount > 0) && ($acceptCount < count($vendorQuotation->vendorQuotationProducts))) {
                    $values['status'] = 'Partially Accepted';
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
            if ($quotationProduct->status == 'Review') {
                $values['status'] = 'Reviewed';
                event(new QuotationStatusChangeEvent('Quotation', 'Reviewed', $quotationProduct));
            }
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
            $quotationProduct->update($values);
            $vendorQuotation = VendorQuotation::findOrFail($quotationProduct->vendor_quotation_id);
            $vendorQuotation->calculateTotal();

            $data['data'] = new VendorQuotationProductResource($quotationProduct);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
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
            try {
                event(new QuotationStatusChangeEvent('Quotation', $request->status, $quotationProduct));
            } catch (\Exception $exception) {
                $data['message'] = 'Error while sending notification';
                $data['data'] = $exception;
            }

            if ($request->status == 'Approved') {
                $quoProduct = \App\Models\QuotationProduct::findOrFail($quotationProduct->quotation_product_id);
                $quoProduct->price = $quotationProduct->price;
                $quoProduct->shipping_cost = $quotationProduct->shipping_cost;
                $quoProduct->quantity = $quotationProduct->quantity;
                $quoProduct->tax_id = $quotationProduct->tax_id;
                $quoProduct->unit_id = $quotationProduct->unit_id;
                $quoProduct->discount_type = $quotationProduct->discount_type;
                $quoProduct->discount = $quotationProduct->discount;
                $quoProduct->vendor_id = $quotationProduct->vendorQuotation->vendor_id;
                if ($quotationProduct->discount_type == 'Percent') {
                    $discount = ($quotationProduct->price * $quotationProduct->discount) / 100;
                } else {
                    $discount = $quotationProduct->discount ?? 0;
                }
                $quoProduct->grand_total = $quotationProduct->price * $quotationProduct->quantity + $quotationProduct->shipping_cost + ($quotationProduct->price * $quotationProduct->tax->value ?? 0) / 100 - $discount;
                $quoProduct->save();

                $vendorQuotationProducts = VendorQuotationProduct::where('id', '!=', $id)->where('quotation_product_id', $quotationProduct->quotation_product_id)->get();
                foreach ($vendorQuotationProducts as $vendorQuotationProduct) {
                    $vendorQuotationProduct->status = 'Cancelled';
                    $vendorQuotationProduct->save();
                }
            }
            $vendorQuotation = VendorQuotation::findOrFail($quotationProduct->vendor_quotation_id);
            $acceptCount = 0;
            $cancelCount = 0;
            foreach ($vendorQuotation->vendorQuotationProducts as $product) {
                if ($product->status == 'Approved') {
                    $acceptCount = $acceptCount + 1;
                } elseif ($product->status == 'Cancelled') {
                    $cancelCount = $cancelCount + 1;
                }
            }
            if (($vendorQuotation->status == 'Accepted') || ($vendorQuotation->status == 'Partially Accepted')) {
                if ($acceptCount == count($vendorQuotation->vendorQuotationProducts)) {
                    $vendorQuotation->status = 'Approved';
                } elseif ($cancelCount == count($vendorQuotation->vendorQuotationProducts)) {
                    $vendorQuotation->status = 'Cancelled';
                } else {
                    $vendorQuotation->status = 'Partially Approved';
                }
            }
            $vendorQuotation->save();

            $quotation = Quotation::findOrFail($vendorQuotation->quotation_id);
            $quotationProducts = QuotationProduct::collection($quotation->quotationProducts);

            if ($request->status == 'Approved') {
                $quotation->approved_by = auth()->user()->id;
            }

            $approveCount = 0;
            $rejectCount = 0;
            foreach ($quotationProducts as $quoProduct) {
                if ($quoProduct->status == 'Approved') {
                    $approveCount = $approveCount + 1;
                } elseif (($quoProduct->status == 'Cancelled') || ($quoProduct->status == 'Rejected')) {
                    $rejectCount = $rejectCount + 1;
                }
            }
            if (($quotation->status == 'Reviewed') || ($quotation->status == 'Pending')) {
                if (($approveCount != 0) && ($approveCount == count($quotationProducts))) {
                    $quotation->status = 'Approved';
                } elseif (($rejectCount != 0) && ($rejectCount == count($quotationProducts))) {
                    $quotation->status = 'Rejected';
                } elseif ($approveCount > 0) {
                    $quotation->status = 'Partially Approved';
                }
            }
            $quotation->save();
            $data['data'] = new VendorQuotationProductResource($quotationProduct);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    public function quotationStatusUpdate($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $vendorQuotation = VendorQuotation::findOrFail($id);
            $values = $request->only('status');
            $vendorQuotation->update($values);
            foreach ($vendorQuotation->vendorQuotationProducts as $product) {
                if ($request->status == 'Approved') {
                    if (($product->status == 'Review') or ($product->status == 'Reviewed') or ($product->status == 'Accepted')) {
                        $product->update($values);
                        $quotationProduct = \App\Models\QuotationProduct::findOrFail($product->quotation_product_id);
                        $quotationProduct->price = $product->price;
                        $quotationProduct->shipping_cost = $product->shipping_cost;
                        $quotationProduct->quantity = $product->quantity;
                        $quotationProduct->tax_id = $product->tax_id;
                        $quotationProduct->unit_id = $product->unit_id;
                        $quotationProduct->discount_type = $product->discount_type;
                        $quotationProduct->discount = $product->discount;
                        $quotationProduct->vendor_id = $product->vendorQuotation->vendor_id;
                        if ($product->discount_type == 'Percent') {
                            $discount = ($product->price * $product->discount) / 100;
                        } else {
                            $discount = $product->discount;
                        }
                        $quotationProduct->grand_total = $product->price * $product->quantity + $product->shipping_cost + ($product->price * $product->tax->value) / 100 - $discount;
                        $quotationProduct->save();
                    } elseif (($product->status == 'Cancelled') or ($product->status == 'On Progress')) {
                        $vendorQuotation->status = 'Partially Approved';
                    }
                } elseif (($request->status == 'Cancelled')) {
                    if (($product->status == 'Pending') or ($product->status == 'On Progress') or ($product->status == 'Review') or ($product->status == 'Reviewed') or ($product->status == 'Accepted')) {
                        $product->update($values);
                    } elseif ($product->status == 'Approved') {
                        $vendorQuotation->status = 'Partially Approved';
                    }
                } else {
                    $product->update($values);
                }
            }
            $vendorQuotation->save();

            $quotation = Quotation::findOrFail($vendorQuotation->quotation_id);
            $quotationProducts = QuotationProduct::collection($quotation->quotationProducts);

            if ($request->status == 'Approved') {
                $quotation->approved_by = auth()->user()->id;
            }

            $approveCount = 0;
            $rejectCount = 0;
            foreach ($quotationProducts as $quoProduct) {
                if ($quoProduct->status == 'Approved') {
                    $approveCount = $approveCount + 1;
                } elseif (($quoProduct->status == 'Cancelled') || ($quoProduct->status == 'Rejected')) {
                    $rejectCount = $rejectCount + 1;
                }
            }
            if (($quotation->status == 'Reviewed') || ($quotation->status == 'Pending')) {
                if (($approveCount != 0) && ($approveCount == count($quotationProducts))) {
                    $quotation->status = 'Approved';
                } elseif (($rejectCount != 0) && ($rejectCount == count($quotationProducts))) {
                    $quotation->status = 'Rejected';
                } elseif ($approveCount > 0) {
                    $quotation->status = 'Partially Approved';
                }
            }
            $quotation->save();
            $data['quotation'] = new \App\Http\Resources\Quotation($quotation);
            $data['message'] = 'Status updated successfully';
            $data['data'] = new \App\Http\Resources\VendorQuotation($vendorQuotation);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    public function getPendingQuotationCount()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            if (auth()->user()->hasRole(['Vendor'])) {
                $user = User::findOrFail(auth()->user()->id);
                $vendorQuotations = VendorQuotation::where('vendor_id', $user->vendor->id)->where('status', 'Pending')->get();
                $data['data'] = count($vendorQuotations);
            } else {
                $data['success'] = false;
                $data['message'] = 'Error occurred.';
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function getPurchaseOrderList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::findOrFail(auth()->user()->id);
            if ($user->hasRole('Vendor')) {
                $purchaseOrders = PurchaseOrder::where('vendor_id', $user->vendor->id)->get();
            } else {
                abort(403);
            }
            $data['data'] = \App\Http\Resources\PurchaseOrder::collection($purchaseOrders);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred';
        }
        return $data;
    }

    public function purchaseOrderShow($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::findOrFail(auth()->user()->id);
            if ($user->hasRole('Vendor')) {
                $purchaseOrder = PurchaseOrder::where('vendor_id', $user->vendor->id)->where('id', $id)->firstOrFail();
            } else {
                abort(403);
            }
            $data['data'] = new \App\Http\Resources\PurchaseOrder($purchaseOrder);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred';
        }
        return $data;
    }

    public function purchaseOrderUpdate($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::findOrFail(auth()->user()->id);
            if ($user->hasRole('Vendor')) {
                $purchaseOrder = PurchaseOrder::where('vendor_id', $user->vendor->id)->where('id', $id)->firstOrFail();
            } else {
                abort(403);
            }
            $values = $request->all();
            if ($request->status == 'Sent') {
                $values['shipping_date'] = Carbon::now();
            }
            $purchaseOrder->update($values);
            event(new POVendorEvent($purchaseOrder, $request->status));
            $data['data'] = new \App\Http\Resources\PurchaseOrder($purchaseOrder);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred';
            $data['data'] = $e;
        }
        return $data;
    }

    public function paymentShow($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = new RegisterPaymentResource(RegisterPayment::findOrFail($id));
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function paymentStatusUpdate($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $payment = RegisterPayment::findOrFail($id);
            $values = $request->only(['status']);
            $payment->update($values);
            $data['message'] = 'This bill has been accepted successfully.';
            $data['data'] = new RegisterPaymentResource($payment);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data']=$e;
        }
        return $data;
    }
}
