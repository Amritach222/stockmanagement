<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\DateConverter;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\Transfer as TransferResource;
use App\Models\Item;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Setting;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('transfers');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = TransferResource::collection(Transfer::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(TransferRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            if ($request->total_quantity === null) {
                $values['total_quantity'] = 1;
            }
            $values['user_id'] = auth()->user()->id;
            $product = Product::findOrFail($request->product_id);
            if ($request->product_variant_id) {
                $variant = ProductVariant::findOrFail($request->product_variant_id);
            }
            $price = $variant->price ?? $product->cost_price;
            $values['total_cost'] = $values['total_quantity'] * $price;
            $values['grand_total'] = $values['total_cost'] + $request->shipping_cost;
            $transfer = new Transfer($values);
            $transfer->save();
            $currentDate = Carbon::now();
            $convertDate = new DateConverter();
            $nepDate = $convertDate->eng_to_nep($currentDate->format('Y'), $currentDate->format('m'), $currentDate->format('d'));
            $setting = Setting::findOrFail(1);
            if ($setting->fiscal_year_id) {
                $fiscalYear = $setting->fiscalYear;
                $fromDate = $fiscalYear->from;
                $toDate = $fiscalYear->to;
                $fromNepDate = $convertDate->eng_to_nep(Carbon::parse($fromDate)->format('Y'), Carbon::parse($fromDate)->format('m'), Carbon::parse($fromDate)->format('d'));
                $toNepDate = $convertDate->eng_to_nep(Carbon::parse($toDate)->format('Y'), Carbon::parse($toDate)->format('m'), Carbon::parse($toDate)->format('d'));
                $year = $fromNepDate['year'] % 1000 . '/' . $toNepDate['year'] % 100;
            } else {
                $year = $nepDate['year'] % 1000;
            }
            if ($nepDate['month'] < 10) {
                $month = '-0' . $nepDate['month'];
            } else {
                $month = '-' . $nepDate['month'];
            }
            $transfer->reference_no = 'TRA-0'.$year . $month . '-' . $transfer->id;
            $transfer->save();
            if($request->tax_id !== null){
                $transfer->totalTax($request->tax_id);
            }
            event(new ActivityLogEvent('Add', 'Transfer', $transfer->id));
            $data['message'] = "Transfer added successfully.";
            $data['data'] = new TransferResource($transfer);
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
            $data['data'] = new TransferResource(Transfer::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, TransferRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $transfer = Transfer::findOrFail($id);
            $values = $request->all();
            if ($request->product_id !== null) {
                $product = Product::findOrFail($request->product_id);
            } else {
                $product = Item::findOrFail($transfer->product_id);
            }
            if ($request->product_variant_id != null) {
                $variant = ProductVariant::findOrFail($request->product_variant_id);
            } elseif ($transfer->product_variant_id !== null) {
                $variant = ProductVariant::findOrFail($transfer->product_variant_id);
            }
            $price = $variant->price ?? $product->cost_price;
            if (($request->total_quantity !== null)) {
                $values['total_cost'] = $request->total_quantity * $price;
                $values['grand_total'] = $values['total_cost'] + $request->shipping_cost + $transfer->total_tax;
            } else {
                $values['grand_total'] = $transfer->total_cost + $request->shipping_cost + $transfer->total_tax;
            }
            $transfer->update($values);
            if($request->tax_id !== null){
                $transfer->totalTax($request->tax_id);
            }
            event(new ActivityLogEvent('Edit', 'Transfer', $transfer->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new TransferResource($transfer);
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
            $transfer = Transfer::findOrFail($id);
            $transfer->delete();
            event(new ActivityLogEvent('Delete', 'Transfer', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
