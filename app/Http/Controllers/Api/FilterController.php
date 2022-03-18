<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
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
            $requestVendorId = '';
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
            if ($request->vendor_id) {
                $requestVendorId = $request->vendor_id;
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
            if($requestVendorId != null){
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
                })->with(['quotationProducts' => function ($query) use ($requestVendorId) {
                    $query->where('vendor_id', $requestVendorId);
                }])->get();
            }else {
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
            }
            $data['data'] = \App\Http\Resources\Quotation::collection($quotations);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
            $data['data'] = $e;
        }
        return $data;
    }

    public function purchase(Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $requestIds = [];
            $requestStatus = [];
            $requestDepartmentIds = [];
            $requestDueFrom = '';
            $requestDueTo = '';
            $requestCreatedTo = '';
            $requestCreatedFrom = '';
            if ($request->ids) {
                $requestIds = json_decode($request->ids);
            }
            if ($request->status) {
                $requestStatus = json_decode($request->status);
            }
            if ($request->department_ids) {
                $requestDepartmentIds = json_decode($request->department_ids);
            }
            if ($request->due_from) {
                $requestDueFrom = $request->due_from;
            }
            if ($request->due_to) {
                $requestDueTo = $request->due_to;
            } else {
                $requestDueTo = $requestDueFrom;
            }
            if ($request->created_from) {
                $requestCreatedFrom = $request->created_from;
            }
            if ($request->created_to) {
                $requestCreatedTo = $request->created_to;
            } else {
                $requestCreatedTo = $requestCreatedFrom;
            }
            $purchases = Purchase::whereIn('id',$requestIds)->when($requestStatus != null, function ($query) use ($requestStatus) {
                return $query->whereIn('status', $requestStatus);
            })->when($requestDepartmentIds != null, function ($query) use ($requestDepartmentIds) {
                return $query->whereIn('department_id', $requestDepartmentIds);
            })->when($requestDueFrom != null, function ($query) use ($requestDueFrom) {
                return $query->where('due_date', '>=', $requestDueFrom);
            })->when($requestDueTo != null, function ($query) use ($requestDueTo) {
                return $query->where('due_date', '<=', $requestDueTo);
            })->when($requestCreatedFrom != null, function ($query) use ($requestCreatedFrom) {
                return $query->where('created_at', '>=', $requestCreatedFrom);
            })->when($requestCreatedTo != null, function ($query) use ($requestCreatedTo) {
                return $query->where('created_at', '<=', $requestCreatedTo);
            })->get();
            $data['data'] = \App\Http\Resources\Purchase::collection($purchases);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
            $data['data'] = $e;
        }
        return $data;
    }
}
