<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthUserResource;
use App\Http\Resources\RoleResource;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function getUserPermissions($username)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::where('username', $username)->firstOrFail();
            if ($user->isVendor()) {
                return response(['success' => false, "message" => 'No permission for this user.'], 403);
            }
            $permissions = [];
            foreach (Permission::where('guard_name', 'api')->get() as $permission) {
                if ($user->can($permission->name)) {
                    $permissions[] = $permission->name;
                }
            }
            $user->permissions = array_unique($permissions);
            $data['data'] = new AuthUserResource($user);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "An error occurred.";
            $data['data'] = $e;
        }
        return $data;
    }

    public function getVendorPermissions($username)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $user = User::where('username', $username)->firstOrFail();
            $permissions = [];
            foreach (Permission::where('guard_name', 'api')->get() as $permission) {
                if ($user->can($permission->name)) {
                    $permissions[] = $permission->name;
                }
            }
            $user->permissions = array_unique($permissions);
            $data['data'] = new AuthUserResource($user);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "An error occurred.";
            $data['data'] = $e;
        }
        return $data;
    }

    public function getRolePermissions($name)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $role = Role::where('name', $name)->where('guard_name', 'api')->firstOrFail();
            $rolePermissions = $role->permissions()->get();
            $permissions = [];
            foreach ($rolePermissions as $permission) {
                $permissions[] = $permission->name;
            }
            $role->permissions = array_unique($permissions);
            $data['data'] = new RoleResource($role);
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

    public function updateUserPermissions(Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $requestPermissions = json_decode($request->permissions);
            $user = User::findOrFail($request->id);
            if ($user->isVendor()) {
                return response(['success' => false, "message" => 'No permission for this user'], 403);
            }
            $permissions = [];
            foreach (Permission::all() as $permission) {
                if ($user->can($permission->name)) {
                    $permissions[] = $permission->name;
                }
            }
            $permissions = array_unique($permissions);
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

    public function updateVendorPermissions(Request $request)
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
            $permissions = array_unique($permissions);
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

    public function updateRolePermissions(Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $requestPermissions = json_decode($request->permissions);
            $role = Role::findOrFail($request->id);
            $rolePermissions = $role->permissions()->get();
            $users = User::role($role->name)->get();
            $permissions = [];
            foreach ($rolePermissions as $permission) {
                $permissions[] = $permission->name;
            }
            $permissions = array_unique($permissions);
            foreach ($permissions as $permission) {
                if (!in_array($permission, $requestPermissions)) {
                    $role->revokePermissionTo([$permission]);
                }
            }
            for ($i = 0; $i < count($requestPermissions); $i++) {
                if (!in_array($requestPermissions[$i], $permissions)) {
                    $role->givePermissionTo([$requestPermissions[$i]]);
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
