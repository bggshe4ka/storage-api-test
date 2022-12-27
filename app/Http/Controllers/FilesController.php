<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\User;
use App\Models\Folder;
use App\Models\Link;
use Illuminate\Support\Str;




class FilesController extends Controller
{

    CONST MAX_USER_FILES_SIZE = 104857600; // 100 MB

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::Check()) { return view('index'); }

        $user_folders = \DB::table('folders')->where('user_id', Auth::User()->id)->get();
        $user_cloud_size = User::getAllFileSizes(Auth::User()->id);
        $user_cloud_size = round($user_cloud_size / 1024 / 1024, 2);

        $total_cloud_size = File::getSizeOfAllFiles();

        return view('index', compact('user_folders', 'user_cloud_size', 'total_cloud_size'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filesPage() {
        $user_files = \DB::table('files')->where('user_id', Auth::User()->id)->where('folder_id', '0')->get();
        $user_folders = \DB::table('folders')->where('user_id', Auth::User()->id)->get();
        $size_of_files = \DB::table('files')->where('user_id', Auth::User()->id)->sum('size');

        return view('files_index', compact('user_files', 'user_folders', 'size_of_files'));

    }

    /**
     * Display a listing of the resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function folderFiles($id) {
        $user_files = File::where('folder_id', $id)->get();

        return view('files_folder', compact('user_files'));
    }

    /**
     * Store a newly created resource in storage.
     *  
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        'file' => 'required|mimes:avi,csv,txt,xlx,xls,pdf|max:20000'
        ]);
        $extension = $request->file->getClientOriginalExtension();
        if ($extension == 'php') {
            return back()
            ->with('message', 'Загрузка PHP файлов запрещена');
            
        }

        $size_user_files = User::getAllFileSizes(Auth::User()->id);
        if ($size_user_files + $request->file('file')->getSize() >= self::MAX_USER_FILES_SIZE) {
            return back()
            ->with('message', 'Вы привысите лимит');
        }

 
        $fileModel = new File;
        if($request->file()) {
            $fileName = $request->file->getClientOriginalName();
            $exists = Storage::disk('public')->exists(Auth::User()->store_folder_name.'/'.$fileName);
            if ($exists) { $fileName = Str::random(5).'_'.$fileName; }
            $filePath = $request->file('file')->storeAs(Auth::User()->store_folder_name, $fileName, 'public');
            $fileModel->name = $fileName;
            $fileModel->path = $filePath;
            $fileModel->size = $request->file('file')->getSize();
            $fileModel->folder_id = $request->input('folder_select');
            $fileModel->user_id = $request->user()->id;
            $fileModel->save();
            return back()
            ->with('message', 'Файл загружен')
            ->with('file', $fileName);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (strpos($request->file_name, '.php')) {
            return back()->with('message', 'PHP файлы запрещены');
        }
        $file_model = File::find($id);
        $file_model->name = $request->file_name;
        $file_model->save();

        return redirect('/files');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file_model = File::find($id);
        if ($file_model->user_id == Auth::User()->id) {
            $file_model->delete(); 
 
            Storage::disk('public')->delete($file_model->path);  
        } else
            return 'You are delete not your own file!';
        

        return back();
    }

    /**
     * Download your own file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function download($id) {
        $fileModel= File::find($id);
        return Storage::disk('public')->download($fileModel->path, $fileModel->name);

   }
   /**
     * Display the page to rename the file.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function editPage($id) {
        $file_to_edit = File::find($id);
        return view('file_edit', compact('file_to_edit'));
   }

   /**
     * Store a newly public link.
     *
     * @param  int  $file_id
     * @return \Illuminate\Http\Response
     */
   public function generatePublicLink($file_id) {
        $link_model = new Link();
        $link_model->slug = Str::random(10);
        $link_model->file_id = $file_id; 
        $link_model->save();
        $public_link = Link::checkLinkExists($file_id);
        return redirect()->back()->with('message', 'Публичная ссылка: '.env('APP_URL').''.$public_link);
   }

   /**
     * Download operation to public file
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
   public function downloadPublicFile($slug) {
        $link_model = Link::where('slug', $slug)->first();
        $file_model = File::find($link_model->file_id);

        return Storage::disk('public')->download($file_model->path);
   }
}
