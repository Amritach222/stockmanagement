<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function generateAllMiddlewareByPermission($permissionName = null)
    {
        if ($permissionName !== null) {
            $this->middleware('permission:' . $permissionName)->only('index');
            $this->middleware('permission:' . $permissionName . '.show')->only('show');
            $this->middleware('permission:' . $permissionName . '.create')->only('create', 'store');
            $this->middleware('permission:' . $permissionName . '.edit')->only('edit', 'update');
            $this->middleware('permission:' . $permissionName . '.delete')->only('destroy');
        }
    }

}
