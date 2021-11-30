<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetLimitRequest;
use App\Http\Resources\BudgetLimit as BudgetLimitResource;
use App\Models\BudgetLimit;
use Illuminate\Http\Request;

class BudgetLimitController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('budgetLimits');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = BudgetLimitResource::collection(BudgetLimit::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(BudgetLimitRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $budgetLimit = new BudgetLimit($values);
            $budgetLimit->save();
            event(new ActivityLogEvent('Add', 'Budget Limit', $budgetLimit->id));
            $data['message'] = "Budget Limit added successfully.";
            $data['data'] = new BudgetLimitResource($budgetLimit);
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
            $data['data'] = new BudgetLimitResource(BudgetLimit::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, BudgetLimitRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $budgetLimit = BudgetLimit::findOrFail($id);
            $values = $request->all();
            $budgetLimit->update($values);
            event(new ActivityLogEvent('Edit', 'Budget Limit', $budgetLimit->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new BudgetLimitResource($budgetLimit);
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
            $budgetLimit = BudgetLimit::findOrFail($id);
            $budgetLimit->delete();
            event(new ActivityLogEvent('Delete', 'Budget Limit', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
