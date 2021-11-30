<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Http\Resources\Category as CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('categories');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = CategoryResource::collection(Category::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(CategoryRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $category = new Category($values);
            $category->save();
            event(new ActivityLogEvent('Add', 'Category', $category->id));
            $data['message'] = "Category added successfully.";
            $data['data'] = new CategoryResource($category);
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
            $data['data'] = new CategoryResource(Category::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, CategoryRequest $request)
    {

        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $category = Category::findOrFail($id);
            if ($request->name !== null && $request->name != $category->name) {
                $categories = Category::where('name', $request->name)->get();
                if (count($categories) > 0) {
                    return response(['success' => false, "message" => 'Category already exist.', "data" => []], 200);
                }
            }
            $values = $request->all();
            $category->update($values);
            event(new ActivityLogEvent('Edit', 'Category', $category->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new CategoryResource($category);
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
            $category = Category::findOrFail($id);
            $category->delete();
            event(new ActivityLogEvent('Delete', 'Category', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
