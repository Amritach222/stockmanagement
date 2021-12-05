<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAttributeGroupRequest;
use App\Http\Resources\ProductAttributeGroup as ProductAttributeGroupResource;
use App\Models\ProductAttributeGroup;
use Illuminate\Http\Request;

class ProductAttributeGroupController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('attributeGroups');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = ProductAttributeGroupResource::collection(ProductAttributeGroup::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ProductAttributeGroupRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $productAttributeGroup = new ProductAttributeGroup($values);
            $productAttributeGroup->save();
            event(new ActivityLogEvent('Add', 'Product Attribute Group', $productAttributeGroup->id));
            $data['message'] = "Product Attribute group added successfully.";
            $data['data'] = new ProductAttributeGroupResource($productAttributeGroup);
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
            $data['data'] = new ProductAttributeGroupResource(ProductAttributeGroup::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ProductAttributeGroupRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $productAttributeGroup = ProductAttributeGroup::findOrFail($id);
            $values = $request->all();
            $productAttributeGroup->update($values);
            event(new ActivityLogEvent('Edit', 'Product Attribute Group', $productAttributeGroup->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ProductAttributeGroupResource($productAttributeGroup);
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
            $productAttributeGroup = ProductAttributeGroup::findOrFail($id);
            $productAttributeGroup->delete();
            event(new ActivityLogEvent('Delete', 'Product Attribute Group', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
