<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Brand as BrandResource;
use App\Models\Brand;
use App\Http\Requests\Brand as BrandRequest;
use App\Models\File;
use Samundra\File\SamundraFileHelper;

class BrandController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = BrandResource::collection(Brand::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(BrandRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();

            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'brand');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data couldnot be saved at the moment', "data" => null], 400);
                }
                $newFile = new File();
                $newFile->extension = $file['data']['extension'];
                $newFile->original_name = $file['data']['original_filename'];
                $newFile->name = $file['data']['filename'];
                $newFile->type = $file['data']['mime_type'];
                $newFile->path = $file['data']['link'];
                $newFile->save();
                $values['image_id'] = $newFile->id;
            }
            $brand = new Brand($values);
            $brand->save();
            event(new ActivityLogEvent('Add', 'Brand', $brand->id));
            $data['message'] = "Brand added successfully.";
            $data['data'] = new BrandResource($brand);
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
            $data['data'] = new BrandResource(Brand::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, BrandRequest $request)
    {
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $brand = Brand::findOrFail($id);
            if ($request->name !== null && $request->name != $brand->name) {
                $brands = Brand::where('name', $request->name)->where('id','!=',$id)->get();
                if (count($brands) > 0) {
                    return response(['success' => false, "message" => 'Brand already exist.', "data" => []], 200);
                }
            }
            $values = $request->all();
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'brand');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data couldnot be saved at the moment', "data" => null], 400);
                }
                if($brand->image_id === null){
                    $newFile = new File();
                } else {
                    $newFile = File::where('id',$brand->image_id)->first();
                    if($newFile === null){
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
                if($hasdata === 1){
                    $newFile->update();
                } else {
                    $newFile->save();
                }
                $values['image_id'] = $newFile->id;
            }

            $brand->update($values);
            event(new ActivityLogEvent('Edit', 'Brand', $brand->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new BrandResource($brand);
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
            $brand = Brand::findOrFail($id);
            $fileHelper = new SamundraFileHelper();
            if ($brand->image_id !== null) {
                $file = File::where('id', $brand->image_id)->first();
                if ($file !== null) {
                    $fileHelper->deleteFile($file->path);
                }
            }
            $brand->delete();
            $file = File::where('id',$brand->image_id)->first();
            if($file !== null){
                $fileHelper = new SamundraFileHelper();
                $fileHelper->deleteFile($file->path);
            }
            event(new ActivityLogEvent('Delete', 'Brand', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
