<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\CodeGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVariantRequest;
use App\Models\File;
use App\Models\Item;
use App\Models\Product;
use App\Models\ProductAttributeGroup;
use App\Http\Resources\ProductVariant as ProductVariantResource;
use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class ProductVariantController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('productVariants');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = ProductVariantResource::collection(ProductVariant::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ProductVariantRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();

            $common = 0;

            $requestAttributeIds = json_decode($request->attribute_ids);

            $product = Product::findOrFail($request->product_id);
            if (count($product->productVariants) > 0) {
                foreach ($product->productVariants as $variant) {
                    $variantAttributeIds = ProductVariantAttribute::where('product_variant_id', $variant->id)->pluck('attribute_id');
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
            }


            if ($common == 0) {
                $values['code'] = CodeGenerator::code();
                if ($request->hasFile('image')) {
                    $fileHelper = new SamundraFileHelper();
                    $file = $fileHelper->saveFile($request->image, 'productVariant');
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
                $productVariant = new ProductVariant($values);
                $productVariant->save();
                $productVariant->attributes()->sync($requestAttributeIds);

                event(new ActivityLogEvent('Add', 'Product Variant', $productVariant->id));
                $data['message'] = "Product Variant added successfully.";
                $data['data'] = new \App\Http\Resources\ProductVariant($productVariant);
            } else {
                $data['success'] = false;
                $data['message'] = "Product Variant already added.";
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
            $data['data'] = new ProductVariantResource(ProductVariant::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ProductVariantRequest $request)
    {
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $productVariant = ProductVariant::findOrFail($id);
            $values = $request->all();
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'productVariant');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if ($productVariant->image_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $productVariant->image_id)->first();
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
            $productVariant->update($values);
            event(new ActivityLogEvent('Edit', 'Product Variant', $productVariant->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ProductVariantResource($productVariant);
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
            $productVariant = ProductVariant::findOrFail($id);
            $fileHelper = new SamundraFileHelper();
            if ($productVariant->image_id !== null) {
                $file = File::where('id', $productVariant->image_id)->first();
                if ($file !== null) {
                    $fileHelper->deleteFile($file->path);
                }
            }
            $productVariant->delete();
            event(new ActivityLogEvent('Delete', 'Product Variant', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
