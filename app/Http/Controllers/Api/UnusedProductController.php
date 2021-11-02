<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\CodeGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnusedProductRequest;
use App\Http\Resources\UnusedProduct as UnusedProductResource;
use App\Models\UnusedProduct;
use Illuminate\Http\Request;

class UnusedProductController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = UnusedProductResource::collection(UnusedProduct::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(UnusedProductRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $values['code'] = CodeGenerator::code();
            $values['user_id'] = auth()->user()->id;
            $unusedProduct = new UnusedProduct($values);
            $unusedProduct->save();
            event(new ActivityLogEvent('Add', 'Unused Product', $unusedProduct->id));
            $data['message'] = "Unused Product added successfully.";
            $data['data'] = new UnusedProductResource($unusedProduct);
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
            $data['data'] = new UnusedProductResource(UnusedProduct::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, UnusedProductRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $unusedProduct = UnusedProduct::findOrFail($id);
            $values = $request->all();
            $unusedProduct->update($values);
            event(new ActivityLogEvent('Edit', 'Unused Product', $unusedProduct->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new UnusedProductResource($unusedProduct);
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
            $unusedProduct = UnusedProduct::findOrFail($id);
            $unusedProduct->delete();
            event(new ActivityLogEvent('Delete', 'Unused Product', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
