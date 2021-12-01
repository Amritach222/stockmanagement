<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAttributeRequest;
use App\Http\Resources\ProductAttribute as ProductAttributeResource;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('attributes');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = ProductAttributeResource::collection(ProductAttribute::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ProductAttributeRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $productAttribute = new ProductAttribute($values);
            $productAttribute->save();
            event(new ActivityLogEvent('Add', 'Product Attribute', $productAttribute->id));
            $data['message'] = "Product Attribute added successfully.";
            $data['data'] = new ProductAttributeResource($productAttribute);
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
            $data['data'] = new ProductAttributeResource(ProductAttribute::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ProductAttributeRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $productAttribute = ProductAttribute::findOrFail($id);
            $values = $request->all();
            $productAttribute->update($values);
            event(new ActivityLogEvent('Update', 'Product Attribute', $productAttribute->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ProductAttributeResource($productAttribute);
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
            $productAttribute = ProductAttribute::findOrFail($id);
            $productAttribute->delete();
            event(new ActivityLogEvent('Delete', 'Product Attribute', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
