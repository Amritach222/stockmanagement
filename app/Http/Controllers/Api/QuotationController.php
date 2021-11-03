<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\DateConverter;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use App\Http\Resources\Quotation as QuotationResource;
use App\Models\File;
use App\Models\Item;
use App\Models\ItemVariant;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

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
            $quotation->reference_no = 'QUO-0'.$year . $month . '-' . $quotation->id;
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
                $file = $fileHelper->saveFile($request->file, 'budget');
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
