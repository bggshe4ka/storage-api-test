<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFolderRequest;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folder = Folder::all();

        return response()->json([
            'status' => true,
            'folder' => $folder
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\StoreFolderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFolderRequest $request)
    {
        $folder_name = $request->name;
        $folder_user_id = $request->user_id;

        $folder_model = Folder::where('user_id',$folder_user_id)->where('name', $folder_name)->first();
        
        if (is_null($folder_model)) {

            $folder = new Folder();
            $folder->name = $folder_name;
            $folder->user_id = $folder_user_id;
            $folder->save();

            return response()->json([
                'status' => true,
                'message' => 'Folder: '. $folder_name . ' with user id - '. $folder_user_id. ' has been successfully created',
                'result' => $folder
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Folder by this user is already created',
                'result' => false
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\StoreFolderRequest  $request
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFolderRequest $request, Folder $folder)
    {
        $folder->update($request->all());

        return response()->json([
                'status' => true,
                'message' => 'Folder edited',
                'result' => $folder
            ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();

        return response()->json([
                'status' => true,
                'message' => 'Folder deleted'
            ]);
    }
}
