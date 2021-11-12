<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequestRequest;
use App\Http\Resources\BudgetRequest as BudgetRequestResource;
use App\Models\BudgetRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

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
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'budgetRequest');
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
        $hasdata=0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $budgetRequest = BudgetRequest::findOrFail($id);
            $values = $request->all();
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'budgetRequest');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if ($budgetRequest->file_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $budgetRequest->file_id)->first();
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
            $fileHelper = new SamundraFileHelper();
            if ($budgetRequest->file_id !== null) {
                $file = File::where('id', $budgetRequest->file_id)->first();
                if ($file !== null) {
                    $fileHelper->deleteFile($file->path);
                }
            }
            $budgetRequest->delete();
            event(new ActivityLogEvent('Delete', 'Budget Request', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
