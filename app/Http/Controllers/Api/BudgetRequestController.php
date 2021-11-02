<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequestRequest;
use App\Http\Resources\BudgetRequest as BudgetRequestResource;
use App\Models\BudgetRequest;
use Illuminate\Http\Request;

class BudgetRequestController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = BudgetRequestResource::collection(BudgetRequest::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(BudgetRequestRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $budgetRequest = new BudgetRequest($values);
            $budgetRequest->save();
            event(new ActivityLogEvent('Add', 'Budget Request', $budgetRequest->id));
            $data['message'] = "Budget Request added successfully.";
            $data['data'] = new BudgetRequestResource($budgetRequest);
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
            $data['data'] = new BudgetRequestResource(BudgetRequest::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, BudgetRequestRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $budgetRequest = BudgetRequest::findOrFail($id);
            $values = $request->all();
            $budgetRequest->update($values);
            event(new ActivityLogEvent('Edit', 'Budget Request', $budgetRequest->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new BudgetRequestResource($budgetRequest);
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
            $budgetRequest = BudgetRequest::findOrFail($id);
            $budgetRequest->delete();
            event(new ActivityLogEvent('Delete', 'Budget Request', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
