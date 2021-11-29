<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogEvent;
use App\Http\Requests\UserEditRequest;
use App\Http\Resources\AuthResource;
use App\Models\File;
use Samundra\File\SamundraFileHelper;

class UserController extends Controller
{
    public function editProfile(UserEditRequest $request)
    {
        $hasdata = 0;
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            if ($request->has('user_id')) {
                $user = User::where('id',$request->user_id)->first();
                if($user === null) return response(['success' => false, 'message' => 'User not found!', "data" => null], 400);
            }
            if ($request->has('username')) {
                $user->username = $request->username;
            }
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('is_active')) {
                $user->is_active = $request->is_active;
            }
        }
        if ($request->has('department_id')) {
            $user->department_id = $request->department_id;
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('address')) {
            $user->address = $request->address;
        }
        if ($request->has('mobile_no')) {
            $user->mobile_no = $request->mobile_no;
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('image')) {
            $fileHelper = new SamundraFileHelper();
            $file = $fileHelper->saveFile($request->image, 'profile');
            if ($file['success'] !== true) {
                return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
            }
            if ($user->profile_picture_id === null) {
                $newFile = new File();
            } else {
                $newFile = File::where('id', $user->profile_picture_id)->first();
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
            $user->profile_picture_id = $newFile->id;
        }

        $user->update();
        event(new ActivityLogEvent('Edit', 'User', $user->id));
        return new AuthResource($user);
    }

    public function getProfilePic()
    {
        $file_id = auth()->user()->profile_picture_id;
        if ($file_id === null) {
            return response(['success' => false, 'message' => 'Data could not be fetched at this moment', "data" => null], 200);

        } else {
            $file = File::where('id', $file_id)->first();
            if ($file === null) {
                return response(['success' => false, 'message' => 'Data could not be fetched at this moment', "data" => null], 200);

            } else {
                return response(['success' => true, 'message' => 'Profile Picture Fetched', "data" => $file->path], 200);
            }
        }
    }
}
