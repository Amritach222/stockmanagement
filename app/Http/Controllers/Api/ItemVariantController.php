<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\CodeGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemVariantRequest;
use App\Models\Attribute;
use App\Models\ItemAttributeGroup;
use App\Http\Resources\ItemVariant as ItemVariantResource;
use App\Models\ItemAttribute;
use App\Models\ItemVariant;
use Illuminate\Http\Request;

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


            $requestAttributeIds = json_decode($request->attribute_ids);

            //Check if given attribute_ids are exiting id or not.
            try {
                foreach ($requestAttributeIds as $id){
                    $attribute = Attribute::findOrFail($id);
                }
            }catch (\Exception $exception){
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
            $attrIdsArray = [];
            if (count($attributeGroups) == 3) {
                $x = $attributeGroups[0]['attributes'];
                $y = $attributeGroups[1]['attributes'];
                $z = $attributeGroups[2]['attributes'];

                for ($i = 0; $i < count($x); $i++) {
                    for ($j = 0; $j < count($y); $j++) {
                        for ($k = 0; $k < count($z); $k++) {
                            $attrIdsArray[] = [$x[$i]->id, $y[$j]->id, $z[$k]->id];
                        }
                    }
                }
            } elseif (count($attributeGroups) == 2) {
                $x = $attributeGroups[0]['attributes'];
                $y = $attributeGroups[1]['attributes'];
                for ($i = 0; $i < count($x); $i++) {
                    for ($j = 0; $j < count($y); $j++) {
                        $attrIdsArray[] = [$x[$i]->id, $y[$j]->id];
                    }
                }
            } elseif (count($attributeGroups) == 1) {
                $attrIdsArray = $requestAttributeIds;
            }
//            } else {
//                return response(['success' => false, "message" => trans('messages.error_server'), "data" => []], 500);
//            }

            foreach ($attrIdsArray as $attrIds) {
                $values['code']=CodeGenerator::code();
                $itemVariant = new ItemVariant($values);
                $itemVariant->save();
                $itemVariant->attributes()->sync($attrIds);
            }

            event(new ActivityLogEvent('Add', 'Item Variant', $itemVariant->id));
            $data['message'] = "Item Variant added successfully.";
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
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $itemVariant = ItemVariant::findOrFail($id);
            $values = $request->all();
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
            $itemVariant->delete();
            event(new ActivityLogEvent('Delete', 'Item Variant', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
