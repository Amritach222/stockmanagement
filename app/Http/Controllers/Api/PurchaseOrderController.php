<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\ReferenceNoGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseOrderRequest;
use App\Http\Requests\PurchaseProductRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\PurchaseOrder as PurchaseOrderResource;
use App\Http\Resources\PurchaseOrderProduct as PurchaseOrderProductResource;
use App\Models\File;
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
            $reqQuotationProducts = json_decode($request->products);
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
                foreach ($reqQuotationProducts as $reqQuotationProduct) {
                    $quotationProduct = QuotationProduct::findOrFail($reqQuotationProduct->quotation_product_id);
                    if ($quotationProduct->vendor_id == $vendor->id) {
                        $purchaseOrderProduct = new PurchaseOrderProduct();
                        $purchaseOrderProduct->purchase_order_id = $purchaseOrder->id;
                        $purchaseOrderProduct->quotation_product_id = $quotationProduct->id;
                        $purchaseOrderProduct->product_id = $quotationProduct->product_id;
                        $purchaseOrderProduct->product_variant_id = $quotationProduct->product_variant_id;
                        $purchaseOrderProduct->quantity = $quotationProduct->quantity;
                        $purchaseOrderProduct->price = $quotationProduct->price;
                        $purchaseOrderProduct->total = $quotationProduct->total;
                        $purchaseOrderProduct->unit_id = $quotationProduct->unit_id;
                        $purchaseOrderProduct->tax_id = $quotationProduct->tax_id;
                        $purchaseOrderProduct->shipping_cost = $quotationProduct->shipping_cost;
                        $purchaseOrderProduct->grand_total = $quotationProduct->grand_total;
                        $purchaseOrderProduct->save();
                    }
                }
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
}
