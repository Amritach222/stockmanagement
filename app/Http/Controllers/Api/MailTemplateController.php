<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\MailTemplate as MailTemplateResource;
use App\Models\MailTemplate;
use Illuminate\Http\Request;

class MailTemplateController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('mailTemplates');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = MailTemplateResource::collection(MailTemplate::all());
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
            $data['template'] = new MailTemplateResource(MailTemplate::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return view($data['template']->view_page, $data);
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
            $template = MailTemplate::findOrFail($id);
            $values = $request->all();
            $template->update($values);
            event(new ActivityLogEvent('Edit', 'Mail Template', $template->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new MailTemplateResource($template);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function destroy($id)
    {
        $data['success'] = false;
        $data['message'] = 'Mail Template cannot be delete.';
        $data['data'] = [];
        return $data;
    }
}
