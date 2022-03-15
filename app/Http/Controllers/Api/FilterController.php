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
            if($request->status){
                $requestStatus = json_decode($request->status);
            }
            if($request->department_ids){
                $requestDepartmentIds = json_decode($request->department_ids);
            }
            if($request->delivery_from){
                $requestDeliveryFrom = $request->delivery_from;
            }
            if($request->delivery_to){
                $requestDeliveryTo = $request->delivery_to;
            }
            if($request->created_from){
                $requestCreatedFrom = $request->created_from;
            }
            if($request->created_to){
                $requestCreatedTo = $request->created_to;
            }
            $quotations = Quotation::whereIn('status',$requestStatus)->whereIn('department_id',$requestDepartmentIds)->where('desired_delivery_date','>=',$requestDeliveryFrom)->where('desired_delivery_date','<=',$requestDeliveryTo)->where('created_at','>=',$requestCreatedFrom)->where('created_at','<=',$requestCreatedTo)->get();
            $data['data']=\App\Http\Resources\Quotation::collection($quotations);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
            $data['data']=$e;
        }
        return $data;
    }
}
