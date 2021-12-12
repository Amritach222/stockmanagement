<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\UnitCategory as UnitCategoryResource;
use App\Http\Requests\UnitCategoryRequest;
use App\Models\UnitCategory;
use Illuminate\Http\Request;

class UnitCategoryController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('units');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = UnitCategoryResource::collection(UnitCategory::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(UnitCategoryRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $unit = new UnitCategory($values);
            $unit->save();
            event(new ActivityLogEvent('Add', 'Unit Category', $unit->id));
            $data['message'] = "Unit Category added successfully.";
            $data['data'] = new UnitCategoryResource($unit);
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
            $data['data'] = new UnitCategoryResource(UnitCategory::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, UnitCategoryRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $unit = UnitCategory::findOrFail($id);
            if ($request->name !== null && $request->name != $unit->name) {
                $units = UnitCategory::where('name', $request->name)->get();
                if (count($units) > 0) {
                    return response(['success' => false, "message" => 'Unit already exist.', "data" => []], 200);
                }
            }
            $values = $request->all();
            $unit->update($values);
            event(new ActivityLogEvent('Edit', 'Unit Category', $unit->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new UnitCategoryResource($unit);
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
            $unit = UnitCategory::findOrFail($id);
            $unit->delete();
            event(new ActivityLogEvent('Delete', 'Unit Category', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
