<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Http\Resources\Vendor as VendorResource;
use App\Models\File;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class VendorController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('vendors');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = VendorResource::collection(Vendor::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(VendorRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $request->merge(['mobile_no' => $request->mobile]);
            $values = $request->all();
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'vendor');
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
                $values['image_id'] = $newFile->id;
                $values['profile_picture_id'] = $newFile->id;
            }
            $user = new User($values);
            $user->save();
            $values['user_id'] = $user->id;
            $user->assignRole('Vendor');
            $vendor = new Vendor($values);
            $vendor->save();
            event(new ActivityLogEvent('Add', 'Vendor', $vendor->id));
            $data['message'] = "Vendor added successfully.";
            $data['data'] = new VendorResource($vendor);
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
            $data['data'] = new VendorResource(Vendor::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, VendorRequest $request)
    {
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $vendor = Vendor::findOrFail($id);
            $user=null;
            if ($vendor->user_id !== null) {
                $user = User::findOrFail($vendor->user_id);
            }
            $request->merge(['mobile_no' => $request->mobile]);
            $values = $request->all();
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'vendor');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if ($vendor->image_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $vendor->image_id)->first();
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
                $values['image_id'] = $newFile->id;
                $values['profile_picture_id'] = $newFile->id;
            }
            if ($user === null) {
                $user = new User($values);
                $user->save();
                $values['user_id'] = $user->id;
            } else {
                $user->update($values);
            }
            $vendor->update($values);
            event(new ActivityLogEvent('Edit', 'Vendor', $vendor->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new VendorResource($vendor);
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
            $vendor = Vendor::findOrFail($id);
            $vendor->delete();
            event(new ActivityLogEvent('Delete', 'vendor', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
