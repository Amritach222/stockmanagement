<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function getPermissions()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $permissions = [];
            foreach (Permission::all() as $permission) {
                if (Auth::user()->can($permission->name)) {
                    $permissions[] = $permission->name;
                }
            }
            $data['data'] = $permissions;
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
}
