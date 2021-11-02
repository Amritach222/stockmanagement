<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemAttributeRequest;
use App\Http\Resources\ItemAttribute as ItemAttributeResource;
use App\Models\ItemAttribute;
use Illuminate\Http\Request;

class ItemAttributeController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = ItemAttributeResource::collection(ItemAttribute::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ItemAttributeRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $itemAttribute = new ItemAttribute($values);
            $itemAttribute->save();
            event(new ActivityLogEvent('Add', 'Item Attribute', $itemAttribute->id));
            $data['message'] = "Item Attribute added successfully.";
            $data['data'] = new ItemAttributeResource($itemAttribute);
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
            $data['data'] = new ItemAttributeResource(ItemAttribute::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ItemAttributeRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $itemAttribute = ItemAttribute::findOrFail($id);
            $values = $request->all();
            $itemAttribute->update($values);
            event(new ActivityLogEvent('Update', 'Item Attribute', $itemAttribute->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ItemAttributeResource($itemAttribute);
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
            $itemAttribute = ItemAttribute::findOrFail($id);
            $itemAttribute->delete();
            event(new ActivityLogEvent('Delete', 'Item Attribute', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
