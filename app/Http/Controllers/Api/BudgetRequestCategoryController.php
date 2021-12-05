<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\BudgetRequestCategory as BudgetRequestCategoryResource;
use App\Http\Requests\BudgetRequestCategoryRequest;
use App\Models\BudgetRequestCategory;
use Illuminate\Http\Request;

class BudgetRequestCategoryController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('budgetRequestCategories');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = BudgetRequestCategoryResource::collection(BudgetRequestCategory::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BudgetRequestCategoryRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $budgetRequestCategory = new BudgetRequestCategory($values);
            $budgetRequestCategory->save();
            event(new ActivityLogEvent('Add', 'Budget Request Category', $budgetRequestCategory->id));
            $data['message'] = "Budget Request Category added successfully.";
            $data['data'] = new BudgetRequestCategoryResource($budgetRequestCategory);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\BudgetRequestCategory $budgetRequestCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = new BudgetRequestCategoryResource(BudgetRequestCategory::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\BudgetRequestCategory $budgetRequestCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetRequestCategory $budgetRequestCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BudgetRequestCategory $budgetRequestCategory
     * @return \Illuminate\Http\Response
     */
    public function update(BudgetRequestCategoryRequest $request, $id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $budgetRequestCategory = BudgetRequestCategory::findOrFail($id);
            $values = $request->all();
            $budgetRequestCategory->update($values);
            event(new ActivityLogEvent('Edit', 'Budget Request Category', $budgetRequestCategory->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new BudgetRequestCategoryResource($budgetRequestCategory);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\BudgetRequestCategory $budgetRequestCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $budgetRequestCategory = BudgetRequestCategory::findOrFail($id);
            $budgetRequestCategory->delete();
            event(new ActivityLogEvent('Delete', 'Budget Request Category', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
