<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Events\POVendorEvent;
use App\Helpers\ReferenceNoGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseOrderRequest;
use App\Http\Requests\PurchaseProductRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\PurchaseOrder as PurchaseOrderResource;
use App\Http\Resources\PurchaseOrderProduct as PurchaseOrderProductResource;
use App\Models\File;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\PurchaseProduct;
use App\Models\QuotationProduct;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('purchases');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = PurchaseOrderResource::collection(PurchaseOrder::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function changeStatusOfPurchaseListsProducts($id, PurchaseProductRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $purchaseProduct = PurchaseOrderProduct::findOrFail($id);
            $values = $request->all();
            $purchaseProduct->update($values);
            event(new ActivityLogEvent('Edit', 'Purchase Order Product', $purchaseProduct->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new PurchaseOrderProductResource($purchaseProduct);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function store(PurchaseOrderRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $user = User::findOrFail(auth()->user()->id);
            if (!$request->has('user_id')) {
                $values['user_id'] = $user->id;
            }
            if (!$request->has('department_id')) {
                $values['department_id'] = $user->department_id;
            }
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'purchaseOrder');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                $newFile = new File();
                $newFile->extension = $file['data']['extension'];
                $newFile->original_name = $file['data']['original_filename'];
                $newFile->name = $file['data']['filename'];
                $newFile->type = $file['data']['mime_type'];
                $newFile->path = $file['data']['link'];
                $newFile->save();
                $values['file_id'] = $newFile->id;
            }
            $reqVendors = json_decode($request->vendors);
            $reqProducts = json_decode($request->products);
            foreach ($reqVendors as $reqVendor) {
                $vendor = Vendor::findOrFail($reqVendor->id);
                $values['supplier'] = $vendor->company_name;
                $values['vendor_id'] = $vendor->id;
                $values['reference'] = '-';
                $values['date_of_order'] = Carbon::now();
                $purchaseOrder = new PurchaseOrder($values);
                $purchaseOrder->save();
                $ref = ReferenceNoGenerator::referenceNo();
                $purchaseOrder->reference = 'PO-0' . $ref . '-' . $purchaseOrder->id;
                $purchaseOrder->save();
                $po_total = 0;
                if ($request->is_from_quotation == 1) {
                    foreach ($reqProducts as $reqProduct) {
                        $quotationProduct = new \App\Http\Resources\QuotationProduct(QuotationProduct::findOrFail($reqProduct->quotation_product_id));
                        if ($quotationProduct->vendor_id == $vendor->id) {
                            $purchaseOrderProduct = new PurchaseOrderProduct([
                                'purchase_order_id' => $purchaseOrder->id,
                                'quotation_product_id' => $reqProduct->quotation_product_id,
                                'product_id' => $quotationProduct->product_id,
                                'product_variant_id' => $quotationProduct->product_variant_id,
                                'quantity' => $quotationProduct->quantity,
                                'price' => $quotationProduct->price,
                                'total' => $quotationProduct->total,
                                'unit_id' => $quotationProduct->unit_id,
                                'tax_id' => $quotationProduct->tax_id,
                                'shipping_cost' => $quotationProduct->shipping_cost,
                                'grand_total' => $quotationProduct->grand_total
                            ]);
                            $purchaseOrderProduct->save();
                            $po_total = $po_total + $purchaseOrderProduct->grand_total;
                        }
                    }
                } else {
                    foreach ($reqProducts as $reqProduct) {
                        if ($reqProduct->vendor_id == $vendor->id) {
                            $purchaseOrderProduct = new PurchaseOrderProduct();
                            $purchaseOrderProduct->purchase_order_id = $purchaseOrder->id;
                            $purchaseOrderProduct->product_id = $reqProduct->product_id;
                            if ($reqProduct->product_variant_id != null) {
                                $purchaseOrderProduct->product_variant_id = $reqProduct->product_variant_id;
                            }
                            $purchaseOrderProduct->quantity = $reqProduct->quantity;
                            $purchaseOrderProduct->price = $reqProduct->price;
                            $purchaseOrderProduct->total = $reqProduct->total;
                            $purchaseOrderProduct->unit_id = $reqProduct->unit_id;
//                            $purchaseOrderProduct->tax_id = $reqProduct->tax_id;
                            $purchaseOrderProduct->shipping_cost = $reqProduct->shipping_cost;
                            $purchaseOrderProduct->grand_total = $reqProduct->grand_total;
                            $purchaseOrderProduct->save();
                            $po_total = $po_total + $purchaseOrderProduct->grand_total;
                        }
                    }
                }
                event(new POVendorEvent($purchaseOrder, 'Create'));
                $purchaseOrder->total = $po_total;
                $purchaseOrder->save();
            }
            event(new ActivityLogEvent('Add', 'PurchaseOrder', $purchaseOrder->id));
            $data['message'] = "Purchase Order added successfully.";
            $data['data'] = new PurchaseOrderResource($purchaseOrder);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    function random_id($digit)
    {
        $rand = rand(10, 1000000);
        return substr(bin2hex($rand), 0, $digit);
    }

    public function show($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = new PurchaseOrderResource(PurchaseOrder::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function update($id, PurchaseOrderRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $purchase = PurchaseOrder::findOrFail($id);
            $values = $request->all();
            $purchase->update($values);
            event(new ActivityLogEvent('Edit', 'PurchaseOrder', $purchase->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new PurchaseOrderResource($purchase);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function destroy($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $purchase = PurchaseOrder::findOrFail($id);
            foreach ($purchase->purchaseOrderProducts as $product) {
                $product->delete();
            }
            $purchase->delete();
            event(new ActivityLogEvent('Delete', 'PurchaseOrder', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function productUpdate($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $purchaseOrderProduct = PurchaseOrderProduct::findOrFail($id);
            $values = $request->all();
            $purchaseOrderProduct->update($values);
            $product = Product::findOrFail($purchaseOrderProduct->product_id);
            $product->cost_price = $purchaseOrderProduct->price;
            $product->stock = $product->stock + $purchaseOrderProduct->received_quantity;
            if ($purchaseOrderProduct->product_variant_id != null) {
                $product = ProductVariant::findOrFail($purchaseOrderProduct->product_variant_id);
                $product->price = $purchaseOrderProduct->price;
                $product->quantity = $product->quantity + $purchaseOrderProduct->received_quantity;
            }
            $product->save();
            if ($purchaseOrderProduct->quantity > $purchaseOrderProduct->received_quantity) {
                $po_values['total'] = $purchaseOrderProduct->price * $purchaseOrderProduct->received_quantity;
                if ($purchaseOrderProduct->tax_id != null) {
                    $po_values['grand_total'] = $po_values['total'] + $purchaseOrderProduct->shipping_cost + $po_values['total'] / 100 * $purchaseOrderProduct->tax->value ?? 0;
                } else {
                    $po_values['grand_total'] = $po_values['total'] + $purchaseOrderProduct->shipping_cost;
                }
                $purchaseOrderProduct->update($po_values);
            }
            $data['message'] = 'Purchase Order Product Update successfully';
            $data['data'] = new PurchaseOrderProductResource($purchaseOrderProduct);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    public function statusUpdate($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            $values = $request->all();
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

    public function createBackOrder($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            $newPurchaseOrder = new PurchaseOrder([
                'reference' => $purchaseOrder->reference,
                'date_of_order' => Carbon::now(),
                'requester' => auth()->user()->name,
                'user_id' => auth()->user()->id,
                'supplier' => $purchaseOrder->supplier,
                'vendor_id' => $purchaseOrder->vendor_id,
                'location' => $purchaseOrder->location,
                'dept_id' => $purchaseOrder->dept_id,
                'file_id' => $purchaseOrder->file_id,
                'description' => $purchaseOrder->description,
                'is_from_quotation' => $purchaseOrder->is_from_quotation
            ]);
            $newPurchaseOrder->save();
            $po_total = 0;
            foreach ($purchaseOrder->purchaseOrderProducts as $product) {
                if ($product->quantity > $product->received_quantity) {
                    $quantity = $product->quantity - $product->received_quantity;
                    $total = $product->price * $quantity;
                    if ($product->tax_id != null) {
                        $grand_total = $total + $product->shipping_cost + $total / 100 * $product->tax->value ?? 0;
                    } else {
                        $grand_total = $total + $product->shipping_cost;
                    }
                    $newPurchaseOrderProduct = new PurchaseOrderProduct([
                        'purchase_product_id' => $newPurchaseOrder->id,
                        'quotation_product_id' => $product->quotation_product_id,
                        'product_id' => $product->product_id,
                        'product_variant_id' => $product->product_variant_id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'total' => $total,
                        'discount_type' => $product->discount_type,
                        'discount' => $product->discount,
                        'unit_id' => $product->unit_id,
                        'tax_id' => $product->tax_id,
                        'shipping_cost' => $product->shipping_cost,
                        'grand_total' => $grand_total,
                    ]);
                    $newPurchaseOrderProduct->save();
                    $po_total = $po_total + $grand_total;
                }
            }
            $newPurchaseOrder->total = $po_total;
            $newPurchaseOrder->save();
            event(new POVendorEvent($newPurchaseOrder, 'Create'));
            event(new ActivityLogEvent('Add', 'PurchaseOrder', $newPurchaseOrder->id));
            $data['data'] = new \App\Http\Resources\PurchaseOrder($purchaseOrder);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred';
            $data['data'] = $e;
        }
        return $data;
    }
}
