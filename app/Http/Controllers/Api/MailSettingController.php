<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\MailSetting as MailSettingResource;
use App\Models\MailSetting;
use Illuminate\Http\Request;

class MailSettingController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('mailSettings');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = new MailSettingResource(MailSetting::findOrFail(1));
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
            $data['data'] = new MailSettingResource(MailSetting::findOrFail($id));
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
            $setting = MailSetting::findOrFail(1);
            $values = $request->all();
            $setting->update($values);
            event(new ActivityLogEvent('Edit', 'Mail Setting', $setting->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new MailSettingResource($setting);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function destroy($id)
    {
        $data['success'] = false;
        $data['message'] = 'Mail Setting cannot be delete.';
        $data['data'] = [];
        return $data;
    }
}
