<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationProductRequest;
use App\Http\Resources\QuotationProduct as QuotationProductResource;
use App\Models\Item;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\QuotationProduct;
use Illuminate\Http\Request;

class QuotationProductController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('quotationProducts');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = QuotationProductResource::collection(QuotationProduct::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(QuotationProductRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $product = Product::findOrFail($request->product_id);
            if ($request->product_variant_id != null) {
                $variant = ProductVariant::findOrFail($request->product_variant_id);
            }
            $price = $variant->price ? $product->cost_price + $variant->price : $product->cost_price;
            $values['price'] = $price;
            $values['tax_id'] = $product->tax_id;
            $quotationProduct = new QuotationProduct($values);
            $quotationProduct->save();
            $quotationProduct->taxCalculate();
            event(new ActivityLogEvent('Add', 'Quotation Product', $quotationProduct->id));
            $data['message'] = "Quotation Product added successfully.";
            $data['data'] = new QuotationProductResource($quotationProduct);
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
            $data['data'] = new QuotationProductResource(QuotationProduct::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, QuotationProductRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $quotationProduct = QuotationProduct::findOrFail($id);
            $values = $request->all();
            if ($request->product_id !== null) {
                $product = Product::findOrFail($request->product_id);
            } else {
                $product = Product::findOrFail($quotationProduct->product_id);
            }
            if ($request->product_variant_id != null) {
                $variant = ProductVariant::findOrFail($request->product_variant_id);
            } elseif ($quotationProduct->product_variant_id !== null) {
                $variant = ProductVariant::findOrFail($quotationProduct->product_variant_id);
            }
            if ($request->product_id != $quotationProduct->product_id) {
                $price = $variant->price ? $product->cost_price + $variant->price : $product->cost_price;
                $values['price'] = $price;
            } elseif ($request->product_variant_id != $quotationProduct->product_variant_id) {
                $price = $variant->price ?? $product->cost_price;
                $values['price'] = $price;
            }

            $values['tax_id'] = $product->tax_id;
            $quotationProduct->update($values);
            $quotationProduct->update($values);
            $quotationProduct->taxCalculate();

            event(new ActivityLogEvent('Edit', 'Quotation Product', $quotationProduct->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new QuotationProductResource($quotationProduct);
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
            $quotationProduct = QuotationProduct::findOrFail($id);
            $quotationProduct->delete();
            event(new ActivityLogEvent('Delete', 'Quotation Product', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
