<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\ReferenceNoGenerator;
use App\Http\Controllers\Controller;
use App\Http\Resources\RegisterPaymentResource;
use App\Models\PurchaseOrder;
use App\Models\RegisterPayment;
use Illuminate\Http\Request;

class RegisterPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = RegisterPaymentResource::collection(RegisterPayment::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $po = PurchaseOrder::findOrFail($request->purchase_order_id);
            $total = 0;
            foreach ($po->purchaseOrderProducts as $product) {
                $total = $total + $product->total;
            }
            $values['total'] = $total;
            $values['grand_total'] = $po->total;
            $values['due_amount'] = $po->total;
            $values['created_by'] = auth()->user()->id;
            $regPayment = new RegisterPayment($values);
            $regPayment->save();
            $ref = ReferenceNoGenerator::referenceNo();
            $regPayment->reference_no = 'Reg-0' . $ref . '-' . $regPayment->id;
            $regPayment->save();
            event(new ActivityLogEvent('Add', 'Payment Register', $regPayment->id));
            $data['message'] = "Payment register added successfully.";
            $data['data'] = new RegisterPaymentResource($regPayment);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\RegisterPayment $registerPayment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = new RegisterPaymentResource(RegisterPayment::findOrFail($id));
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\RegisterPayment $registerPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(RegisterPayment $registerPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RegisterPayment $registerPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $regPayment = RegisterPayment::findOrFail($id);
            $values = $request->all();

            $regPayment->update($values);
            event(new ActivityLogEvent('Edit', 'Payment Register', $regPayment->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new RegisterPaymentResource($regPayment);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\RegisterPayment $registerPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $regPayment = RegisterPayment::findOrFail($id);
            $regPayment->delete();

            event(new ActivityLogEvent('Delete', 'Payment Register', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function checkIfBillCreated($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $po = PurchaseOrder::findOrFail($id);
            if ($po->registerPayment != null) {
                $data['data']['count'] = 1;
                $data['data']['id'] = $po->registerPayment->id;
            } else {
                $data['data']['count'] = 0;
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }
}
