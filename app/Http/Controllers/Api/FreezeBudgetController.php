<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\FreezeBudgetRequest;
use App\Http\Resources\FreezeBudget as FreezeBudgetResource;
use App\Models\Budget;
use App\Models\Department;
use App\Models\FreezeBudget;
use Illuminate\Http\Request;

class FreezeBudgetController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('freezeBudgets');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = FreezeBudgetResource::collection(FreezeBudget::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(FreezeBudgetRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            try {
                $budget = Budget::where('department_id', $request->department_id)->where('fiscal_year_id', $request->fiscal_year_id)->firstOrFail();
            } catch (\Exception $error) {
                return response(['success' => false, "message" => "No budget found of this department.", "data" => $error], 500);
            }
            if($request->amount === null) {
                if ($budget->allocated_budget_amount > $budget->final_dispatched_amount) {
                    $freezeBudgetAmount = FreezeBudget::where('department_id', $request->department_id)->where('fiscal_year_id', $request->fiscal_year_id)->sum('amount');
                    $values['amount'] = $budget->allocated_budget_amount - $budget->final_dispatched_amount - $freezeBudgetAmount;
                } else {
                    $values['amount'] = 0;
                }
            }
            if ($request->remark == null) {
                $values['remark'] = "Unused budget.";
            }
            $freezeBudget = new FreezeBudget($values);
            $freezeBudget->save();
            event(new ActivityLogEvent('Add', 'Freeze Budget', $freezeBudget->id));
            $data['message'] = "Freeze Budget added successfully.";
            $data['data'] = new FreezeBudgetResource($freezeBudget);
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
            $data['data'] = new FreezeBudgetResource(FreezeBudget::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, FreezeBudgetRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $freezeBudget = FreezeBudget::findOrFail($id);
            $values = $request->all();
            if ((($request->department_id != $freezeBudget->department_id) && ($request->department_id !== null)) && (($request->fiscal_year_id != $freezeBudget->fiscal_year_id) && ($request->fiscal_year_id !== null))) {
                try {
                    $budget = Budget::where('department_id', $request->department_id)->where('fiscal_year_id', $request->fiscal_year_id)->firstOrFail();
                } catch (\Exception $error) {
                    return response(['success' => false, "message" => "No budget found of this department on this fiscal year.", "data" => $error], 500);
                }
            } elseif (($request->department_id != $freezeBudget->department_id) && ($request->department_id !== null)) {
                try {
                    $budget = Budget::where('department_id', $request->department_id)->where('fiscal_year_id', $freezeBudget->fiscal_year_id)->firstOrFail();
                } catch (\Exception $error) {
                    return response(['success' => false, "message" => "No budget found of this department.", "data" => $error], 500);
                }
            } elseif (($request->fiscal_year_id != $freezeBudget->fiscal_year_id) && ($request->fiscal_year_id !== null)) {
                try {
                    $budget = Budget::where('department_id', $freezeBudget->department_id)->where('fiscal_year_id', $request->fiscal_year_id)->firstOrFail();
                } catch (\Exception $error) {
                    return response(['success' => false, "message" => "No budget found on this fiscal year.", "data" => $error], 500);
                }
            } else {
                try {
                    $budget = Budget::where('department_id', $freezeBudget->department_id)->where('fiscal_year_id', $freezeBudget->fiscal_year_id)->firstOrFail();
                } catch (\Exception $error) {
                    return response(['success' => false, "message" => "No budget found of this department.", "data" => $error], 500);
                }
            }
            if($request->amount === null or $request->amount == 0) {
                if ($budget->allocated_budget_amount > $budget->final_dispatched_amount) {
                    $freezeBudgetAmount = FreezeBudget::where('department_id', $request->department_id)->where('fiscal_year_id', $request->fiscal_year_id)->sum('amount');
                    $values['amount'] = $budget->allocated_budget_amount - $budget->final_dispatched_amount - $freezeBudgetAmount;
                } else {
                    $values['amount'] = 0;
                }
            }
            $freezeBudget->update($values);
            event(new ActivityLogEvent('Edit', 'Freeze Budget', $freezeBudget->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new FreezeBudgetResource($freezeBudget);
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
            $freezeBudget = FreezeBudget::findOrFail($id);
            $freezeBudget->delete();
            event(new ActivityLogEvent('Delete', 'Freeze Budget', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
