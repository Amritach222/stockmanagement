<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Item as ItemResource;
use App\Http\Resources\ItemUser as ItemUserResource;
use App\Models\ItemUser;
use App\Models\User;
use Illuminate\Http\Request;

class ItemUserController extends Controller
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
            $data['data'] = ItemUserResource::collection(ItemUser::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = "Error occurred.";
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
    public function store(Request $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $values = $request->all();
            $user = User::findOrFail($request->user_id);
            $values['department_id'] = $user->department_id;
            $itemUser = new ItemUser($values);
            $itemUser->save();
            event(new ActivityLogEvent('Add', 'Item User', $itemUser->id));
            $data['message'] = "Item User added successfully";
            $data['data'] = new ItemUserResource($itemUser);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ItemUser $itemUser
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = new ItemUserResource(ItemUser::findOrFail($id));
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ItemUser $itemUser
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemUser $itemUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ItemUser $itemUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $values = $request->all();
            if ($request->user_id !== null) {
                $user = User::findOrFail($request->user_id);
                $values['department_id'] = $user->department_id;
            }
            $itemUser = ItemUser::findOrFail($id);
            $itemUser->update($values);
            event(new ActivityLogEvent('Edit', 'Item User', $itemUser->id));
            $data['message'] = "Updated successfully";
            $data['data'] = new ItemUserResource($itemUser);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
            $data['data'] = $e;
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ItemUser $itemUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['success']=true;
        $data['message']='';
        $data['data']=[];
        try{
            $itemUser = ItemUser::findOrFail($id);
            $itemUser->delete();
            event(new ActivityLogEvent('Delete', 'Item User', $id));
            $data['message'] = "Item User deleted successfully";
        }catch (\Exception $e){
            $data['success']=true;
            $data['message']='Error occurred.';
            $data['data']=$e;
        }
        return $data;
    }
}
