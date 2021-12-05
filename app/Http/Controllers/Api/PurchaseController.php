<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\Purchase as PurchaseResource;
use App\Models\File;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class PurchaseController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('purchases');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = PurchaseResource::collection(Purchase::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function userPurchaseHistory()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        $user = auth()->user();
        $purchases = Purchase::where('user_id',$user->id)->get();
        $data['data'] = PurchaseResource::collection($purchases);
        return $data;
    }

    public function store(PurchaseRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            if (!$request->has('user_id')) {
                $values['user_id'] = auth()->user()->id;
            }
            if (!$request->has('department_id')) {
                $values['department_id'] = auth()->user()->department_id;
            }
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'purchase');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                $newFile = new File();
                $newFile->extension = $file['data']['extension'];
                $newFile->original_name = $file['data']['original_filename'];
                $newFile->name = $file['data']['filename'];
                $newFile->type = $file['data']['mime_type'];
                $newFile->path = $file['data']['link'];
                $newFile->save();
                $values['file_id'] = $newFile->id;
            }
            $purchase = new Purchase($values);
            $purchase->save();
            event(new ActivityLogEvent('Add', 'Purchase', $purchase->id));
            $data['message'] = "Purchase added successfully.";
            $data['data'] = new PurchaseResource($purchase);
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
            $data['data'] = new PurchaseResource(Purchase::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function update($id, PurchaseRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $purchase = Purchase::findOrFail($id);
            $values = $request->all();
            $purchase->update($values);
            $purchase->total();
            event(new ActivityLogEvent('Edit', 'Purchase', $purchase->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new PurchaseResource($purchase);
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
            $purchase = Purchase::findOrFail($id);
            foreach ($purchase->purchaseProducts as $product) {
                $product->delete();
            }
            $purchase->delete();
            event(new ActivityLogEvent('Delete', 'Purchase', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
