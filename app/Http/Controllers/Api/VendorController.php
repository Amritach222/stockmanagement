<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Http\Resources\Vendor as VendorResource;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('vendors');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = VendorResource::collection(Vendor::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(VendorRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $vendor = new Vendor($values);
            $vendor->save();
            event(new ActivityLogEvent('Add', 'Vendor', $vendor->id));
            $data['message'] = "Vendor added successfully.";
            $data['data'] = new VendorResource($vendor);
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
            $data['data'] = new VendorResource(Vendor::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, VendorRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $vendor = Vendor::findOrFail($id);
            $values = $request->all();
            $vendor->update($values);
            event(new ActivityLogEvent('Edit', 'Vendor', $vendor->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new VendorResource($vendor);
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
            $vendor = Vendor::findOrFail($id);
            $vendor->delete();
            event(new ActivityLogEvent('Delete', 'vendor', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
