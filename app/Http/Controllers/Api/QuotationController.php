<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\DateConverter;
use App\Helpers\ReferenceNoGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use App\Http\Resources\Quotation as QuotationResource;
use App\Models\File;
use App\Models\Item;
use App\Models\ProductVariant;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class QuotationController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('quotations');
    }

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
            $values['status'] = 'Pending';
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'quotation');
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
            $quotation = new Quotation($values);
            $quotation->save();
            $ref = ReferenceNoGenerator::referenceNo();
            $quotation->reference_no = 'QUO-0' . $ref . '-' . $quotation->id;
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
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $quotation = Quotation::findOrFail($id);
            $values = $request->all();
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'quotation');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if ($quotation->file_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $quotation->file_id)->first();
                    if ($newFile === null) {
                        $newFile = new File();
                    } else {
                        $hasdata = 1;
                        $fileHelper->deleteFile($newFile->path);
                    }
                }

                $newFile->extension = $file['data']['extension'];
                $newFile->original_name = $file['data']['original_filename'];
                $newFile->name = $file['data']['filename'];
                $newFile->type = $file['data']['mime_type'];
                $newFile->path = $file['data']['link'];
                if ($hasdata === 1) {
                    $newFile->update();
                } else {
                    $newFile->save();
                }
                $values['file_id'] = $newFile->id;
            }
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
                foreach ($product->vendorQuotationProducts as $vendorQuotationProduct) {
                    $vendorQuotationProduct->delete();
                }
                $product->delete();
            }
            foreach ($quotation->vendorQuotations as $vendorQuotation) {
                $fileHelper1 = new SamundraFileHelper();
                if ($quotation->file_id !== null) {
                    $file = File::where('id', $vendorQuotation->file_id)->first();
                    if ($file !== null) {
                        $fileHelper1->deleteFile($file->path);
                    }
                }
                $vendorQuotation->delete();
            }
            $fileHelper = new SamundraFileHelper();
            if ($quotation->file_id !== null) {
                $file = File::where('id', $quotation->file_id)->first();
                if ($file !== null) {
                    $fileHelper->deleteFile($file->path);
                }
            }
            $quotation->delete();
            event(new ActivityLogEvent('Delete', 'Quotation', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function approvedList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $quotations = Quotation::whereIn('status', ['Approved', 'Partially Approved'])->get();
            foreach ($quotations as $quotation) {
                $quotationProducts = [];
                $quotationProducts = \App\Http\Resources\QuotationProduct::collection($quotation->quotationProducts);
                foreach ($quotationProducts as $quotationProduct) {
                    if ($quotationProduct->status == 'Approved') {
                        $quotationProducts[] = $quotationProduct;
                    }
                }
                $quotation->quotationProducts = $quotationProducts;
            }
            $data['data'] = QuotationResource::collection($quotations);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred';
        }
        return $data;
    }
}
