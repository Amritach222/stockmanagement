<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\Department as DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = DepartmentResource::collection(Department::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(DepartmentRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $department = new Department($values);
            $department->save();
            event(new ActivityLogEvent('Add', 'Department', $department->id));
            $data['message'] = "Department added successfully.";
            $data['data'] = new DepartmentResource($department);
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
            $data['data'] = new DepartmentResource(Department::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, DepartmentRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $department = Department::findOrFail($id);
            if ($request->name !== null && $request->name != $department->name) {
                $departments = Department::where('name', $request->name)->get();
                if (count($departments) > 0) {
                    return response(['success' => false, "message" => 'Department already exist.', "data" => []], 200);
                }
            }
            $values = $request->all();
            $department->update($values);
            event(new ActivityLogEvent('Edit', 'Department', $department->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new DepartmentResource($department);
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
            $department = Department::findOrFail($id);
            $department->delete();
            event(new ActivityLogEvent('Delete', 'Department', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
