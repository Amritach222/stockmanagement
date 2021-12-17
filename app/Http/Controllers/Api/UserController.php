<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Http\Requests\UserRegistration;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class UserController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('users');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = AuthResource::collection(User::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
            $data['data'] = $e;
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(UserRegistration $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'profilePicture');
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
                $values['profile_picture_id'] = $newFile->id;
            }
            $user = new User($values);
            $user->save();
            $user->assignRole($request->role);
            event(new ActivityLogEvent('Add', 'User', $user->id));
            $data['message'] = "User added successfully.";
            $data['data'] = new AuthResource($user);
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
            $data['data'] = new AuthResource(User::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, UserRegistration $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $user = User::findOrFail($id);
            $values = $request->all();
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'profilePicture');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if($user->profile_picture_id === null){
                    $newFile = new File();
                } else {
                    $newFile = File::where('id',$user->profile_picture_id)->first();
                    if($newFile === null){
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
                if($hasdata === 1){
                    $newFile->update();
                } else {
                    $newFile->save();
                }
                $values['profile_picture_id'] = $newFile->id;
            }
            $user->update($values);
            event(new ActivityLogEvent('Edit', 'User', $user->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new AuthResource($user);
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
            $user = User::findOrFail($id);
            $file = File::where('id',$user->profile_picture_id)->first();
            if($file !== null){
                $fileHelper = new SamundraFileHelper();
                $fileHelper->deleteFile($file->path);
            }
            $user->delete();
            event(new ActivityLogEvent('Delete', 'User', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
