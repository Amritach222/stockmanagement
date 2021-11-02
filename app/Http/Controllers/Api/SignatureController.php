<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignatureRequest;
use App\Http\Resources\Signature as SignatureResource;
use App\Models\File;
use App\Models\Signature;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class SignatureController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = SignatureResource::collection(Signature::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(SignatureRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'brand');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data couldnot be saved at the moment', "data" => null], 400);
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
            $signature = new Signature($values);
            $signature->save();
            event(new ActivityLogEvent('Add', 'Signature', $signature->id));
            $data['message'] = "Signature added successfully.";
            $data['data'] = new SignatureResource($signature);
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
            $data['data'] = new SignatureResource(Signature::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, SignatureRequest $request)
    {
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $signature = Signature::findOrFail($id);
            $values = $request->all();
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'brand');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data couldnot be saved at the moment', "data" => null], 400);
                }
                if ($signature->file_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $signature->file_id)->first();
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
            $signature->update($values);
            event(new ActivityLogEvent('Edit', 'Signature', $signature->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new SignatureResource($signature);
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
            $signature = Signature::findOrFail($id);
            $signature->delete();
            event(new ActivityLogEvent('Delete', 'Signature', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
