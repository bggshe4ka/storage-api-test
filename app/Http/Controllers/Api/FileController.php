<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFileRequest;


class FileController extends Controller
{

    CONST MAX_USER_FILES_SIZE = 104857600;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $file = File::all();

        return response()->json([
            'status' => true,
            'message' => '',
            'result' => $file
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\StoreFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request)
    {
        if($request->file('file')) {
            $extension = $request->file->getClientOriginalExtension();
            if ($extension == 'php') { return response()->json(['status' => true, 'message' => 'PHP Files banned', 'result' => false]); }    
        }        

        $size_user_files = User::getAllFileSizes($request->user_id);
        if ($size_user_files + $request->file('file')->getSize() >= self::MAX_USER_FILES_SIZE) { return response()->json(['status' => true, 'message' => 'User total size limit', 'result' => false]); }

        $fileModel = new File;
        if($request->file('file')) {
            $fileName = $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs(User::find($request->user_id)->store_folder_name, $fileName, 'public');
            $fileModel->name = $request->file->getClientOriginalName();
            $fileModel->path = $filePath;
            $fileModel->size = $request->file('file')->getSize();
            $fileModel->folder_id = $request->folder_id;
            $fileModel->user_id = $request->user_id;
            $fileModel->save();
    
            return response()->json([
                'status' => true,
                'message' => 'File uploaded',
                'result' => $fileModel
            ]);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        $file->name = $request->name;
        $file->save();

        return response()->json([
                'status' => true,
                'message' => 'File edited',
                'result' => $file
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $file->delete();

        return response()->json([
                'status' => true,
                'message' => 'File deleted'
            ]);
    }
}
