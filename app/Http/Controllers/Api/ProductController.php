<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\CodeGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product as ProductResource;
use App\Models\File;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeGroup;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class ProductController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('products');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = ProductResource::collection(Product::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ProductRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $values['code'] = CodeGenerator::code();
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'product');
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

            $product = new Product($values);
            $product->save();
            event(new ActivityLogEvent('Add', 'Product', $product->id));
            $data['message'] = "Product added successfully.";
            $data['data'] = new ProductResource($product);
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
            $data['data'] = new ProductResource(Product::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ProductRequest $request)
    {
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $product = Product::findOrFail($id);
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'product');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if ($product->image_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $product->image_id)->first();
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
            $product->update($values);
            event(new ActivityLogEvent('Edit', 'Product', $product->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ProductResource($product);
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
            $product = Product::findOrFail($id);
            $fileHelper = new SamundraFileHelper();
            if ($product->image_id !== null) {
                $file = File::where('id', $product->image_id)->first();
                if ($file !== null) {
                    $fileHelper->deleteFile($file->path);
                }
            }
            $product->delete();
            event(new ActivityLogEvent('Delete', 'Product', $id));
            $data['message'] = "Deleted Successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }


    public function createVariants(Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {

//            $requestAttributeIds = json_decode($request->attribute_ids, true);

            $requestAttributeIds = json_decode($request->attribute_ids);

            //Check if given attribute_ids are exiting id or not.
            try {
                for ($i = 0; $i < count($requestAttributeIds); $i++) {
                    $attribute = ProductAttribute::findOrFail($requestAttributeIds[$i]);
                }
            } catch (\Exception $exception) {
                return response(['success' => false, "message" => trans('messages.error_server'), "data" => $exception], 500);
            }


            $attributeGroups = ProductAttributeGroup::whereHas('attributes', function ($q) use ($requestAttributeIds) {
                $q->whereIn('id', $requestAttributeIds);
            })->get();
            foreach ($attributeGroups as $attributeGroup) {
                $attributeGroup['attributes'] = ProductAttribute::where('attribute_group_id', $attributeGroup->id)
                    ->whereIn('id', $requestAttributeIds)->get();
            }

            //Grouping attributes for variants
//            $attrIdsArray = [];
            $collection = [];
            if (count($attributeGroups) == 3) {
                $x = $attributeGroups[0]['attributes'];
                $y = $attributeGroups[1]['attributes'];
                $z = $attributeGroups[2]['attributes'];

                for ($i = 0; $i < count($x); $i++) {
                    for ($j = 0; $j < count($y); $j++) {
                        for ($k = 0; $k < count($z); $k++) {
                            $l = count($collection);
//                            $attrIdsArray[] = [$x[$i]->id, $y[$j]->id, $z[$k]->id];
                            $collection[$l]['attribute_group_ids'] = [$x[$i]->attribute_group_id, $y[$j]->attribute_group_id, $z[$k]->attribute_group_id];
                            $collection[$l]['attribute_ids'] = [$x[$i]->id, $y[$j]->id, $z[$k]->id];
                            $collection[$l]['name'] = $x[$i]->name . ' - ' . $y[$j]->name . ' - ' . $z[$k]->name;
                        }
                    }
                }
            } elseif (count($attributeGroups) == 2) {
                $x = $attributeGroups[0]['attributes'];
                $y = $attributeGroups[1]['attributes'];
                for ($i = 0; $i < count($x); $i++) {
                    for ($j = 0; $j < count($y); $j++) {
                        $l = count($collection);
//                        $attrIdsArray[] = [$x[$i]->id, $y[$j]->id];
                        $collection[$l]['attribute_group_ids'] = [$x[$i]->attribute_group_id, $y[$j]->attribute_group_id];
                        $collection[$l]['attribute_ids'] = [$x[$i]->id, $y[$j]->id];
                        $collection[$l]['name'] = $x[$i]->name . ' - ' . $y[$j]->name;
                    }
                }
            } elseif (count($attributeGroups) == 1) {
                $x = $attributeGroups[0]['attributes'];
//                $attrIdsArray = $requestAttributeIds;
                for ($i = 0; $i < count($x); $i++) {
                    $l = count($collection);
                    $collection[$l]['attribute_group_ids'] = [$x[$i]->attribute_group_id];
                    $collection[$l]['attribute_ids'] = [$x[$i]->id];
                    $collection[$l]['name'] = $x[$i]->name;
                }
            }
            $data['data'] = $collection;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
            $data['data'] = $e;
        }
        return $data;
    }
}
