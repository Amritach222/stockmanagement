<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use App\Http\Resources\Quotation as QuotationResource;
use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = QuotationResource::collection(Quotation::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(QuotationRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $values['user_id'] = auth()->user()->id;
            $quotation = new Quotation($values);
            $quotation->save();
            event(new ActivityLogEvent('Add', 'Quotation', $quotation->id));
            $data['message'] = "Quotation added successfully.";
            $data['data'] = new QuotationResource($quotation);
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
            $data['data'] = new QuotationResource(Quotation::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, QuotationRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $quotation = Quotation::findOrFail($id);
            $values = $request->all();
            $quotation->update($values);
            event(new ActivityLogEvent('Edit', 'Quotation', $quotation->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new QuotationResource($quotation);
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
            $quotation = Quotation::findOrFail($id);
            foreach ($quotation->quotationProducts as $product) {
                $product->delete();
            }
            $quotation->delete();
            event(new ActivityLogEvent('Delete', 'Quotation', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
