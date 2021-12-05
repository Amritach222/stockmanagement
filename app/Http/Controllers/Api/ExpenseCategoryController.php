<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\CodeGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseCategoryRequest;
use App\Http\Resources\ExpenseCategory as ExpenseCategoryResource;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('expenseCategories');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = ExpenseCategoryResource::collection(ExpenseCategory::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ExpenseCategoryRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $values['code']=CodeGenerator::code();
            $expenseCategory = new ExpenseCategory($values);
            $expenseCategory->save();
            event(new ActivityLogEvent('Add', 'Expense Category', $expenseCategory->id));
            $data['message'] = "Expense Category added successfully.";
            $data['data'] = new ExpenseCategoryResource($expenseCategory);
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
            $data['data'] = new ExpenseCategoryResource(ExpenseCategory::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ExpenseCategoryRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $expenseCategory = ExpenseCategory::findOrFail($id);
            $values = $request->all();
            $expenseCategory->update($values);
            event(new ActivityLogEvent('Edit', 'Expense Category', $expenseCategory->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ExpenseCategoryResource($expenseCategory);
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
            $expenseCategory = ExpenseCategory::findOrFail($id);
            $expenseCategory->delete();
            event(new ActivityLogEvent('Delete', 'Expense Category', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
