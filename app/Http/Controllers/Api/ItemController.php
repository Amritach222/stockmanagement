<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Helpers\CodeGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\Item as ItemResource;
use App\Models\File;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeGroup;
use App\Models\ProductVariant;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class ItemController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('items');
    }

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
                $file = $fileHelper->saveFile($request->image, 'item');
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

            $product = Product::findOrFail($request->product_id);
            if ($product->distribute_unit_id != null) {
                $unit = Unit::findOrFail($product->distribute_unit_id);
            } else {
                $unit = Unit::findOrFail($product->unit_id);
            }
            if ($request->product_variant_id != null) {
                $variant = ProductVariant::findOrFail($request->product_variant_id);
                if ($unit->type == 'smaller') {
                    $quantity = ($variant->quantity * $unit->value) - $request->quantity;
                    $variant->quantity = $quantity / $unit->value;
                } elseif ($unit->type == 'bigger') {
                    $quantity = ($variant->quantity / $unit->value) - $request->quantity;
                    $variant->quantity = $quantity * $unit->value;
                } else {
                    $variant->quantity = $variant->quantity - $request->quantity;
                }
                $variant->save();
            }else{
                if ($unit->type == 'smaller') {
                    $quantity = ($product->stock * $unit->value) - $request->quantity;
                    $product->stock = $quantity / $unit->value;
                } elseif ($unit->type == 'bigger') {
                    $quantity = ($product->stock / $unit->value) - $request->quantity;
                    $product->stock = $quantity * $unit->value;
                } else {
                    $product->stock = $product->stock - $request->quantity;
                }
                $product->save();
            }
            if ($request->user_id) {
                $userValues['item_id'] = $item->id;
                $user = User::findOrFail($request->user_id);
                $userValues['user_id'] = $user->id;
                $userValues['department_id'] = $user->department_id;
                $itemUser = new ItemUser($userValues);
                $itemUser->save();
            }
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
            $product = Product::findOrFail($item->product_id);
            if ($product->distribute_unit_id) {
                $unit = Unit::findOrFail($product->distribute_unit_id);
            } else {
                $unit = Unit::findOrFail($product->unit_id);
            }
            if ($item->product_variant_id) {
                $variant = ProductVariant::findOrFail($item->product_variant_id);
                if ($unit->type == 'smaller') {
                    $quantity = ($variant->quantity * $unit->value) + $item->quantity;
                    $variant->quantity = $quantity / $unit->value;
                } elseif ($unit->type == 'bigger') {
                    $quantity = ($variant->quantity / $unit->value) + $item->quantity;
                    $variant->quantity = $quantity * $unit->value;
                } else {
                    $variant->quantity = $variant->quantity + $item->quantity;
                }
                $variant->save();
            }else{
                if ($unit->type == 'smaller') {
                    $quantity = ($product->stock * $unit->value) + $item->quantity;
                    $product->stock = $quantity / $unit->value;
                } elseif ($unit->type == 'bigger') {
                    $quantity = ($product->stock / $unit->value) + $item->quantity;
                    $product->stock = $quantity * $unit->value;
                } else {
                    $product->stock = $product->stock + $item->quantity;
                }
                $product->save();
            }
            $item->update($values);
//            if(!$request->product_id){
//                $request->merge(['product_id'=>$item->product_id]);
//            }
            $product = Product::findOrFail($request->product_id);
            if ($product->distribute_unit_id) {
                $unit = Unit::findOrFail($product->distribute_unit_id);
            } else {
                $unit = Unit::findOrFail($product->unit_id);
            }
            if ($request->product_variant_id) {
                $variant = ProductVariant::findOrFail($request->product_variant_id);
                if ($unit->type == 'smaller') {
                    $quantity = ($variant->quantity * $unit->value) - $request->quantity;
                    $variant->quantity = $quantity / $unit->value;
                } elseif ($unit->type == 'bigger') {
                    $quantity = ($variant->quantity / $unit->value) - $request->quantity;
                    $variant->quantity = $quantity * $unit->value;
                } else {
                    $variant->quantity = $variant->quantity - $request->quantity;
                }
                $variant->save();
            }else{
                if ($unit->type == 'smaller') {
                    $quantity = ($product->stock * $unit->value) - $request->quantity;
                    $product->stock = $quantity / $unit->value;
                } elseif ($unit->type == 'bigger') {
                    $quantity = ($product->stock / $unit->value) - $request->quantity;
                    $product->stock = $quantity * $unit->value;
                } else {
                    $product->stock = $product->stock - $request->quantity;
                }
                $product->save();
            }
            $itemUser = ItemUser::where('item_id', $item->id)->orderBy('created_at', 'desc')->first();
            if ($itemUser->user_id != $request->user_id) {
                $userValues['item_id'] = $item->id;
                $user = User::findOrFail($request->user_id);
                $userValues['user_id'] = $user->id;
                $userValues['department_id'] = $user->department_id;
                $itemUser = new ItemUser($userValues);
                $itemUser->save();
            }
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
}
