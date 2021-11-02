<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Http\Resources\Unit as UnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = UnitResource::collection(Unit::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(UnitRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $unit = new Unit($values);
            $unit->save();
            event(new ActivityLogEvent('Add', 'Unit', $unit->id));
            $data['message'] = "Unit added successfully.";
            $data['data'] = new UnitResource($unit);
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
            $data['data'] = new UnitResource(Unit::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, UnitRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $unit = Unit::findOrFail($id);
            if ($request->name !== null && $request->name != $unit->name) {
                $units = Unit::where('name', $request->name)->get();
                if (count($units) > 0) {
                    return response(['success' => false, "message" => 'Unit already exist.', "data" => []], 200);
                }
            }
            $values = $request->all();
            $unit->update($values);
            event(new ActivityLogEvent('Edit', 'Unit', $unit->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new UnitResource($unit);
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
            $unit = Unit::findOrFail($id);
            $unit->delete();
            event(new ActivityLogEvent('Delete', 'Unit', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
