<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function quotation(Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $requestStatus = [];
            $requestDepartmentIds = [];
            $requestDeliveryFrom = '';
            $requestDeliveryTo = '';
            $requestCreatedTo = '';
            $requestCreatedFrom = '';
            if ($request->status) {
                $requestStatus = json_decode($request->status);
            }
            if ($request->department_ids) {
                $requestDepartmentIds = json_decode($request->department_ids);
            }
            if ($request->delivery_from) {
                $requestDeliveryFrom = $request->delivery_from;
            }
            if ($request->delivery_to) {
                $requestDeliveryTo = $request->delivery_to;
            } else {
                $requestDeliveryTo = $requestDeliveryFrom;
            }
            if ($request->created_from) {
                $requestCreatedFrom = $request->created_from;
            }
            if ($request->created_to) {
                $requestCreatedTo = $request->created_to;
            } else {
                $requestCreatedTo = $requestCreatedFrom;
            }
            $quotations = Quotation::when($requestStatus != null, function ($query) use ($requestStatus) {
                return $query->whereIn('status', $requestStatus);
            })->when($requestDepartmentIds != null, function ($query) use ($requestDepartmentIds) {
                return $query->whereIn('department_id', $requestDepartmentIds);
            })->when($requestDeliveryFrom != null, function ($query) use ($requestDeliveryFrom) {
                return $query->where('desired_delivery_date', '>=', $requestDeliveryFrom);
            })->when($requestDeliveryTo != null, function ($query) use ($requestDeliveryTo) {
                return $query->where('desired_delivery_date', '<=', $requestDeliveryTo);
            })->when($requestCreatedFrom != null, function ($query) use ($requestCreatedFrom) {
                return $query->where('created_at', '>=', $requestCreatedFrom);
            })->when($requestCreatedTo != null, function ($query) use ($requestCreatedTo) {
                return $query->where('created_at', '<=', $requestCreatedTo);
            })->get();
            $data['data'] = \App\Http\Resources\Quotation::collection($quotations);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
            $data['data'] = $e;
        }
        return $data;
    }
}
