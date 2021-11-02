<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsumeRequest;
use App\Http\Resources\Consume as ConsumeResource;
use App\Models\Consume;
use Illuminate\Http\Request;

class ConsumeController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = ConsumeResource::collection(Consume::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ConsumeRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $values['user_id'] = auth()->user()->id;
            $consume = new Consume($values);
            $consume->save();
            event(new ActivityLogEvent('Add', 'Consume', $consume->id));
            $data['message'] = "Consume added successfully.";
            $data['data'] = new ConsumeResource($consume);
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
            $data['data'] = new ConsumeResource(Consume::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ConsumeRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $consume = Consume::findOrFail($id);
            $values = $request->all();
            $consume->update($values);
            event(new ActivityLogEvent('Edit', 'Consume', $consume->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ConsumeResource($consume);
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
            $consume = Consume::findOrFail($id);
            $consume->delete();
            event(new ActivityLogEvent('Delete', 'Consume', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
