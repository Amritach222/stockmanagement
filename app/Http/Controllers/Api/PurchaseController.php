<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseProductRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Resources\Purchase as PurchaseResource;
use App\Http\Resources\PurchaseProduct as PurchaseProductResource;
use App\Http\Resources\PurchaseRequestAdminResource;
use App\Models\File;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class PurchaseController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('purchases');
        $this->middleware(['role:' . 'Department Head'])->only(['changeStatusOfPurchaseListsProducts', 'departmentHeadPurchaseLists']);
        $this->middleware(['role:' . 'Admin|Store Manager|Store Keeper'])->only(['adminPurchaseLists']);
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
        $purchases = Purchase::where('user_id', $user->id)->get();
        $data['data'] = PurchaseResource::collection($purchases);
        return $data;
    }

    public function adminPurchaseLists(Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        $getStatus = $request->query('status');
        if ($getStatus === 'approved') {
            $purchases = Purchase::with('purchaseProducts')->whereHas('purchaseProducts', function ($query) {
                $query->where('department_status', 'Approved');
                $query->where('status', 'Approved');
            }
            )->get();
        }
        elseif ($getStatus === 'rejected') {
            $purchases = Purchase::with('purchaseProducts')->whereHas('purchaseProducts', function ($query) {
                $query->where('department_status', 'Approved');
                $query->where('status', 'Rejected');
            }
            )->get();
        } else {
            $purchases = Purchase::with('purchaseProducts')->whereHas('purchaseProducts', function ($query) {
                $query->where('department_status', 'Approved');
                $query->where('status', 'Pending');
            }
            )->get();
        }

        $data['data'] = PurchaseRequestAdminResource::collection($purchases);
        return $data;
    }

    public function departmentHeadPurchaseLists(Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        $user = auth()->user();
        if ($user->department_id === null) {
            return response(['success' => false, "message" => 'Department id not found', "data" => []], 422);
        } else {
            $getStatus = $request->query('status');
            if ($getStatus === 'approved') {
                $purchases = Purchase::where('department_id', $user->department_id)->with('purchaseProducts')->whereHas('purchaseProducts', function ($query) {
                    $query->where('department_status', 'Approved');
                }
                )->get();
            } elseif ($getStatus === 'rejected') {
                $purchases = Purchase::where('department_id', $user->department_id)->with('purchaseProducts')->whereHas('purchaseProducts', function ($query) {
                    $query->where('department_status', 'Rejected');
                }
                )->get();
            } else {
                $purchases = Purchase::where('department_id', $user->department_id)->with('purchaseProducts')->whereHas('purchaseProducts', function ($query) {
                    $query->where('department_status', 'Pending');
                }
                )->get();
            }

            $data['data'] = PurchaseResource::collection($purchases);
            return $data;
        }

    }

    public function changeStatusOfPurchaseListsProducts($id, PurchaseProductRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $purchaseProduct = PurchaseProduct::findOrFail($id);
            $values = $request->all();
            $purchaseProduct->update($values);
            event(new ActivityLogEvent('Edit', 'Purchase Product', $purchaseProduct->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new PurchaseProductResource($purchaseProduct);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
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
            $values['reference_no'] = 'REF-' . $this->random_id(8);
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

    function random_id($digit)
    {
        $rand = rand(10, 1000000);
        return substr(bin2hex($rand), 0, $digit);
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
