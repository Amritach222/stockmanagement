<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\CodeGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemVariantRequest;
use App\Models\Attribute;
use App\Models\File;
use App\Models\Item;
use App\Models\ItemAttributeGroup;
use App\Http\Resources\ItemVariant as ItemVariantResource;
use App\Models\ItemAttribute;
use App\Models\ItemVariant;
use App\Models\ItemVariantAttribute;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class ItemVariantController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = ItemVariantResource::collection(ItemVariant::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ItemVariantRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();

            $common = 0;

            $requestAttributeIds = json_decode($request->attribute_ids);

            $item = Item::findOrFail($request->item_id);
            foreach ($item->itemVariants as $variant) {
                $variantAttributeIds = ItemVariantAttribute::where('item_variant_id', $variant->id)->pluck('attribute_id');
                if (count($variantAttributeIds) > count($requestAttributeIds)) {
                    foreach ($variantAttributeIds as $id) {
                        if (in_array($id, $requestAttributeIds)) {
                            $common = 1;
                        } else {
                            $common = 0;
                        }
                    }
                } else {
                    foreach ($requestAttributeIds as $id) {
                        if ($variantAttributeIds->contains($id)) {
                            $common = 1;
                        } else {
                            $common = 0;
                        }
                    }
                }
            }


            if ($common == 0) {
                $values['code'] = CodeGenerator::code();
                if ($request->hasFile('image')) {
                    $fileHelper = new SamundraFileHelper();
                    $file = $fileHelper->saveFile($request->image, 'itemVariant');
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
                    $values['image_id'] = $newFile->id;
                }
                $itemVariant = new ItemVariant($values);
                $itemVariant->save();
                $itemVariant->attributes()->sync($requestAttributeIds);

                event(new ActivityLogEvent('Add', 'Item Variant', $itemVariant->id));
                $data['message'] = "Item Variant added successfully.";
                $data['data'] = new \App\Http\Resources\ItemVariant($itemVariant);
            } else {
                $data['success'] = false;
                $data['message'] = "Item Variant already added.";
            }
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
            $data['data'] = new ItemVariantResource(ItemVariant::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ItemVariantRequest $request)
    {
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $itemVariant = ItemVariant::findOrFail($id);
            $values = $request->all();
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'itemVariant');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if ($itemVariant->image_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $itemVariant->image_id)->first();
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
                $values['image_id'] = $newFile->id;
            }
            $itemVariant->update($values);
            event(new ActivityLogEvent('Edit', 'Item Variant', $itemVariant->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ItemVariantResource($itemVariant);
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
            $itemVariant = ItemVariant::findOrFail($id);
            $fileHelper = new SamundraFileHelper();
            if ($itemVariant->image_id !== null) {
                $file = File::where('id', $itemVariant->image_id)->first();
                if ($file !== null) {
                    $fileHelper->deleteFile($file->path);
                }
            }
            $itemVariant->delete();
            event(new ActivityLogEvent('Delete', 'Item Variant', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
