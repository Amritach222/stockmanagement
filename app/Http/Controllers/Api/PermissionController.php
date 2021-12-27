<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function getPermissions($username)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::where('username', $username)->firstOrFail();
            foreach (Permission::all() as $permission) {
                if ($user->can($permission->name)) {
                    $user->permissions[] = $permission->name;
                }
            }
            $data['data'] = new AuthUserResource($user);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "An error occurred.";
            $data['data'] = $e;
        }
        return $data;
    }

    public function assignRole($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::findOrFail($id);
            if ($request->role !== null) {
                $user->assignRole($request->role);
                $data['message'] = 'Role assigned successfully';
                $data['data'] = $user;
            } else {
                $data['success'] = false;
                $data['message'] = "Please give a role.";
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
            $data['data'] = $e;
        }
        return $data;
    }

    public function getAllPermissions()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = Permission::where('guard_name', 'api')->pluck('name');
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    public function updatePermissions(Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $requestPermissions = json_decode($request->permissions);
            $user = User::findOrFail($request->id);
            $permissions = [];
            foreach (Permission::all() as $permission) {
                if ($user->can($permission->name)) {
                    $permissions[] = $permission->name;
                }
            }
            foreach ($permissions as $permission) {
                if (!in_array($permission, $requestPermissions)) {
                    $user->revokePermissionTo([$permission]);
                }
            }
            for ($i = 0; $i < count($requestPermissions); $i++) {
                if (!in_array($requestPermissions[$i], $permissions)) {
                    $user->givePermissionTo([$requestPermissions[$i]]);
                }
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }
}
