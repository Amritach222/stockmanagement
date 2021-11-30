<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignatureUseDepartmentRequest;
use App\Http\Resources\SignatureUseDepartment as SignatureUseDepartmentResource;
use App\Models\SignatureUseDepartment;
use Illuminate\Http\Request;

class SignatureUseDepartmentController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('signatureUseDepartments');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = SignatureUseDepartmentResource::collection(SignatureUseDepartment::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(SignatureUseDepartmentRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $signatureUseDepartment = new SignatureUseDepartment($values);
            $signatureUseDepartment->save();
            event(new ActivityLogEvent('Add', 'Signature Use Department', $signatureUseDepartment->id));
            $data['message'] = "Signature Use Department added successfully.";
            $data['data'] = new SignatureUseDepartmentResource($signatureUseDepartment);
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
            $data['data'] = new SignatureUseDepartmentResource(SignatureUseDepartment::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, SignatureUseDepartmentRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $signatureUseDepartment = SignatureUseDepartment::findOrFail($id);
            $values = $request->all();
            $signatureUseDepartment->update($values);
            event(new ActivityLogEvent('Edit', 'Signature Use Department', $signatureUseDepartment->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new SignatureUseDepartmentResource($signatureUseDepartment);
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
            $signatureUseDepartment = SignatureUseDepartment::findOrFail($id);
            $signatureUseDepartment->delete();
            event(new ActivityLogEvent('Delete', 'Signature Use Department', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
