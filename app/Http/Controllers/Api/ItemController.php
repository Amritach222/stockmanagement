<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\CodeGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\Item as ItemResource;
use App\Models\Attribute;
use App\Models\File;
use App\Models\Item;
use App\Models\ItemAttribute;
use App\Models\ItemAttributeGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class ItemController extends Controller
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
            $data['data'] = ItemResource::collection(Item::all());
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
    public function store(ItemRequest $request)
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
            $item = new Item($values);
            $item->save();
            event(new ActivityLogEvent('Add', 'Item', $item->id));
            $data['message'] = "Item added successfully";
            $data['data'] = new ItemResource($item);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = new ItemResource(Item::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, $id)
    {
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $item = Item::findOrFail($id);
            if ($request->hasFile('image')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->image, 'item');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if ($item->image_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $item->image_id)->first();
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
            $item->update($values);
            event(new ActivityLogEvent('Edit', 'Item', $item->id));
            $data['message'] = "Updated successfully";
            $data['data'] = new ItemResource($item);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $item = Item::findOrFail($id);
            $fileHelper = new SamundraFileHelper();
            if ($item->image_id !== null) {
                $file = File::where('id', $item->image_id)->first();
                if ($file !== null) {
                    $fileHelper->deleteFile($file->path);
                }
            }
            $item->delete();
            event(new ActivityLogEvent('Delete', 'Item', $id));
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
                    $attribute = ItemAttribute::findOrFail($requestAttributeIds[$i]);
                }
            } catch (\Exception $exception) {
                return response(['success' => false, "message" => trans('messages.error_server'), "data" => $exception], 500);
            }


            $attributeGroups = ItemAttributeGroup::whereHas('attributes', function ($q) use ($requestAttributeIds) {
                $q->whereIn('id', $requestAttributeIds);
            })->get();
            foreach ($attributeGroups as $attributeGroup) {
                $attributeGroup['attributes'] = ItemAttribute::where('attribute_group_id', $attributeGroup->id)
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
