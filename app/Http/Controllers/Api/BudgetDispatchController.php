<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\BudgetDispatch as BudgetDispatchResource;
use App\Http\Requests\BudgetDispatchRequest;
use App\Models\BudgetDispatch;
use Illuminate\Http\Request;

class BudgetDispatchController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = BudgetDispatchResource::collection(BudgetDispatch::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(BudgetDispatchRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $budgetDispatch = new BudgetDispatch($values);
            $budgetDispatch->save();
            event(new ActivityLogEvent('Add', 'Budget Dispatch', $budgetDispatch->id));
            $data['message'] = "Budget Dispatch added successfully.";
            $data['data'] = new BudgetDispatchResource($budgetDispatch);
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
            $data['data'] = new BudgetDispatchResource(BudgetDispatch::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, BudgetDispatchRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $budgetDispatch = BudgetDispatch::findOrFail($id);
            $values = $request->all();
            $budgetDispatch->update($values);
            event(new ActivityLogEvent('Edit', 'Budget Dispatch', $budgetDispatch->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new BudgetDispatchResource($budgetDispatch);
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
            $budgetDispatch = BudgetDispatch::findOrFail($id);
            $budgetDispatch->delete();
            event(new ActivityLogEvent('Delete', 'Budget Dispatch', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
