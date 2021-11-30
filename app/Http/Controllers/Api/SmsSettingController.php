<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\SmsSetting as SmsSettingResource;
use App\Models\SmsSetting;
use Illuminate\Http\Request;

class SmsSettingController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('smsSettings');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = SmsSettingResource::collection(SmsSetting::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = new SmsSettingResource(SmsSetting::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $setting = SmsSetting::findOrFail(1);
            $values = $request->all();
            $setting->update($values);
            event(new ActivityLogEvent('Edit', 'Sms Setting', $setting->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new SmsSettingResource($setting);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function destroy($id)
    {
        $data['success'] = false;
        $data['message'] = 'Sms Setting cannot be delete.';
        $data['data'] = [];
        return $data;
    }
}
