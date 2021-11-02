<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnProductRequest;
use App\Http\Resources\ReturnProduct as ReturnProductResource;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\ReturnProduct;
use Illuminate\Http\Request;

class ReturnProductController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = ReturnProductResource::collection(ReturnProduct::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ReturnProductRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $values['user_id'] = auth()->user()->id;
            if ($request->purchase_product_id) {
                $purchaseProduct = PurchaseProduct::findOrFail($request->purchase_product_id);
            }
            $price = $purchaseProduct->price;
            $values['total_cost'] = $request->quantity * $price + $request->shipping_cost;
            $returnProduct = new ReturnProduct($values);
            $returnProduct->save();
            event(new ActivityLogEvent('Add', 'Return Product', $returnProduct->id));
            $data['message'] = "Return Product added successfully.";
            $data['data'] = new ReturnProductResource($returnProduct);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function show($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = new ReturnProductResource(ReturnProduct::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ReturnProductRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $returnProduct = ReturnProduct::findOrFail($id);
            $values = $request->all();
            if ($request->purchase_product_id != null) {
                $purchaseProduct = PurchaseProduct::findOrFail($request->purchase_product_id);
            } elseif ($returnProduct->purchase_product_id !== null) {
                $purchaseProduct = PurchaseProduct::findOrFail($returnProduct->purchase_product_id);
            }
            $price = $purchaseProduct->price;
            if (($request->total_quantity !== null)) {
                $values['total_cost'] = $request->quantity * $price + $request->shipping_cost;
            }else{
                $values['total_cost'] = $returnProduct->total_cost + $request->shipping_cost;
            }
            $returnProduct->update($values);
            event(new ActivityLogEvent('Edit', 'Return Product', $returnProduct->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ReturnProductResource($returnProduct);
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
            $returnProduct = ReturnProduct::findOrFail($id);
            $returnProduct->delete();
            event(new ActivityLogEvent('Delete', 'Return Product', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
