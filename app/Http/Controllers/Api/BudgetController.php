<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequest;
use App\Http\Resources\Budget as BudgetResource;
use App\Models\Budget;
use App\Models\BudgetDispatch;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class BudgetController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('budgets');
    }
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = BudgetResource::collection(Budget::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(BudgetRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
//            $values['date_first_received'] = Carbon::now();
            $values['total_dispatched_amount'] = $request->initial_dispatched_amount;
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'budget');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                $newFile = new File();
                $newFile->extension = $file['data']['extension'];
                $newFile->original_name = $file['data']['original_filename'];
                $newFile->name = $file['data']['filename'];
                $newFile->type = $file['data']['mime_type'];
                $newFile->path = $file['data']['link'];
                $newFile->save();
                $values['file_id'] = $newFile->id;
            }
            $budget = new Budget($values);
            $budget->save();
            $dispatch['budget_id'] = $budget->id;
            $dispatch['amount'] = $budget->initial_dispatched_amount;
            $dispatch['dispatched_date'] = $budget->date_first_received;
            $budgetDispatch = new BudgetDispatch($dispatch);
            $budgetDispatch->save();
            event(new ActivityLogEvent('Add', 'Budget', $budget->id));
            $data['message'] = "Budget added successfully.";
            $data['data'] = new BudgetResource($budget);
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
            $data['data'] = new BudgetResource(Budget::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, BudgetRequest $request)
    {
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $budget = Budget::findOrFail($id);
            $values = $request->all();
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'budget');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if ($budget->file_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $budget->file_id)->first();
                    if ($newFile === null) {
                        $newFile = new File();
                    } else {
                        $hasdata = 1;
                        $fileHelper->deleteFile($newFile->path);
                    }
                }

                $newFile->extension = $file['data']['extension'];
                $newFile->original_name = $file['data']['original_filename'];
                $newFile->name = $file['data']['filename'];
                $newFile->type = $file['data']['mime_type'];
                $newFile->path = $file['data']['link'];
                if ($hasdata === 1) {
                    $newFile->update();
                } else {
                    $newFile->save();
                }
                $values['file_id'] = $newFile->id;
            }
            $budget->update($values);
            event(new ActivityLogEvent('Edit', 'Budget', $budget->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new BudgetResource($budget);
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
            $budget = Budget::findOrFail($id);
            $fileHelper = new SamundraFileHelper();
            if ($budget->file_id !== null) {
                $file = File::where('id', $budget->file_id)->first();
                if ($file !== null) {
                    $fileHelper->deleteFile($file->path);
                }
            }
            $budget->delete();
            event(new ActivityLogEvent('Delete', 'Budget', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
