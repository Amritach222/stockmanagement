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
            $units = Unit::all();
            $name = 0;
            $type = 0;
            $ratio = 0;
            foreach ($units as $aUnit) {
                if ((strtolower($request->name) == strtolower($aUnit->name))) {
                    $name = 1;
                } else if ((($request->type !== 'equal') && ($request->type === $aUnit->type)) && (($request->category_id === $aUnit->category_id) && (($request->value) === ($aUnit->value)))) {
                    $ratio = 1;
                } else if ((($request->type === 'equal') && ($request->type === $aUnit->type)) && ($request->category_id === $aUnit->category_id)) {
                    $type = 1;
                }
            }
            if ($name == 1) {
                $data['success'] = false;
                $data['message'] = "Unit name already exist.";
                return $data;
            } elseif ($type == 1) {
                $data['success'] = false;
                $data['message'] = "Please select a different type for this category.";
                return $data;
            } elseif ($ratio == 1) {
                $data['success'] = false;
                $data['message'] = "Please enter different ratio value.";
                return $data;
            }
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
            $units = Unit::all();
            $name = 0;
            $type = 0;
            $ratio = 0;
            foreach ($units as $aUnit) {
                if (($request->id != $aUnit->id) && (strtolower($request->name) == strtolower($aUnit->name))) {
                    $name = 1;
                } else if ((($request->type !== 'equal') && ($request->id !== $aUnit->id)) && (($request->category_id === $aUnit->category_id) && (($request->type === $aUnit->type) && (($request->value) === ($aUnit->value))))) {
                    $ratio = 1;
                } else if ((($request->type === 'equal') && ($request->type === $aUnit->type)) && (($request->category_id === $aUnit->category_id) && ($request->id !== $aUnit->id))) {
                    $type = 1;
                }
            }
            if ($name == 1) {
                $data['success'] = false;
                $data['message'] = "Unit name already exist.";
                return $data;
            } elseif ($type == 1) {
                $data['success'] = false;
                $data['message'] = "Please select a different type for this category.";
                return $data;
            } elseif ($ratio == 1) {
                $data['success'] = false;
                $data['message'] = "Please enter different ratio value.";
                return $data;
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
            if ((count($unit->products) == 0) && (count($unit->distributeProducts) == 0)) {
                $unit->delete();
                event(new ActivityLogEvent('Delete', 'Unit', $id));
                $data['message'] = "Deleted successfully.";
            } else {
                $data['success'] = false;
                $data['message'] = 'This unit is used in product. You cannot delete this product.';
            }
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
