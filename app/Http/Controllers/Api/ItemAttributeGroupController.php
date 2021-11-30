<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemAttributeGroupRequest;
use App\Http\Resources\ItemAttributeGroup as ItemAttributeGroupResource;
use App\Models\ItemAttributeGroup;
use Illuminate\Http\Request;

class ItemAttributeGroupController extends Controller
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
            $data['data'] = ItemAttributeGroupResource::collection(ItemAttributeGroup::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ItemAttributeGroupRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $itemAttributeGroup = new ItemAttributeGroup($values);
            $itemAttributeGroup->save();
            event(new ActivityLogEvent('Add', 'Item Attribute Group', $itemAttributeGroup->id));
            $data['message'] = "Item Attribute group added successfully.";
            $data['data'] = new ItemAttributeGroupResource($itemAttributeGroup);
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
            $data['data'] = new ItemAttributeGroupResource(ItemAttributeGroup::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ItemAttributeGroupRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $itemAttributeGroup = ItemAttributeGroup::findOrFail($id);
            $values = $request->all();
            $itemAttributeGroup->update($values);
            event(new ActivityLogEvent('Edit', 'Item Attribute Group', $itemAttributeGroup->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ItemAttributeGroupResource($itemAttributeGroup);
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
            $itemAttributeGroup = ItemAttributeGroup::findOrFail($id);
            $itemAttributeGroup->delete();
            event(new ActivityLogEvent('Delete', 'Item Attribute Group', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
