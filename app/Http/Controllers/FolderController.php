<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\User;
use App\Models\Folder;

class FolderController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
        'folder_name' => 'required|string|max:36'
        ]);

        $folder_model = Folder::where('user_id', Auth::User()->id)->where('name', $request->folder_name)->first();

        if (is_null($folder_model)) {
            $folderModel = New Folder();
            $folderModel->name = $request->folder_name;
            $folderModel->user_id = Auth::User()->id;
            $folderModel->save(); 
            return back()->with('message', 'Папка успешно создана');
        } else {
            return back()->with('message', 'Папка с таким названием уже существует');  
        }  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createFolderPage() {
        return view('create_folder');
    }
}
