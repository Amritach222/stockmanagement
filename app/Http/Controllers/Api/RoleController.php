<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = Role::where('name', '!=', 'Super Admin')->where('name', '!=', 'Admin')->where('guard_name', 'api')->get();
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred';
            $data['data'] = $e;
        }
        return $data;
    }
}
