<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\DesignationRequest;
use App\Http\Resources\Designation as DesignationResource;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = DesignationResource::collection(Designation::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(DesignationRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $designation = new Designation($values);
            $designation->save();
            event(new ActivityLogEvent('Add', 'Designation', $designation->id));
            $data['message'] = "Designation added successfully.";
            $data['data'] = new DesignationResource($designation);
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
            $data['data'] = new DesignationResource(Designation::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, DesignationRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $designation = Designation::findOrFail($id);
            if ($request->name !== null && $request->name != $designation->name) {
                $designations = Designation::where('name', $request->name)->where('id','!=',$id)->get();
                if (count($designations) > 0) {
                    return response(['success' => false, "message" => 'Designation already exist.', "data" => []], 200);
                }
            }
            $values = $request->all();
            $designation->update($values);
            event(new ActivityLogEvent('Edit', 'Designation', $designation->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new DesignationResource($designation);
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
            $department = Designation::findOrFail($id);
            $department->delete();
            event(new ActivityLogEvent('Delete', 'Designation', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
