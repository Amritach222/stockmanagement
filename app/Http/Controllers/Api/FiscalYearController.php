<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\FiscalYearRequest;
use App\Http\Resources\FiscalYear as FiscalYearResource;
use App\Models\FiscalYear;
use Illuminate\Http\Request;

class FiscalYearController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('fiscalYears');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = FiscalYearResource::collection(FiscalYear::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(FiscalYearRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $from = date('y',strtotime($request->from));
            $to = date('y',strtotime($request->to));
            $values['name'] = $from . '/' . $to;
            $fiscalYear = new FiscalYear($values);
            $fiscalYear->save();
            event(new ActivityLogEvent('Add', 'Fiscal Year', $fiscalYear->id));
            $data['message'] = "Fiscal Year added successfully.";
            $data['data'] = new FiscalYearResource($fiscalYear);
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
            $data['data'] = new FiscalYearResource(FiscalYear::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, FiscalYearRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $fiscalYear = FiscalYear::findOrFail($id);
            $values = $request->all();
            $fiscalYear->update($values);
            event(new ActivityLogEvent('Edit', 'Fiscal Year', $fiscalYear->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new FiscalYearResource($fiscalYear);
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
            $fiscalYear = FiscalYear::findOrFail($id);
            $fiscalYear->delete();
            event(new ActivityLogEvent('Delete', 'Fiscal Year', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function selectFiscalYear()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $years = FiscalYear::all();
            foreach ($years as $year) {
                $year->value = $year->id;
                $year->text = $year->from . ' || ' . $year->to;
            }
            $data['data'] = $years;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }
}
