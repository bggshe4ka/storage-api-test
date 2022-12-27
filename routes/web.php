<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', 'App\Http\Controllers\FilesController@index');


//Route::get('/dashboard', 'App\Http\Controllers\FilesController@dashboard')->middleware(['auth', 'verified'])->name('dashboard');
// FILES ROUTES // 



Route::post('/create-folder', 'App\Http\Controllers\FolderController@create')->name('folder.create');




Route::get('/omg', 'App\Http\Controllers\FilesController@test');


Route::get('/dl/{slug}', 'App\Http\Controllers\FilesController@downloadPublicFile')->name('downloadbyslug');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/files', 'App\Http\Controllers\FilesController@filesPage')->name('files.index');
    Route::post('/upload-file', 'App\Http\Controllers\FilesController@store')->name('file.upload');
	Route::post('/update/{id}', 'App\Http\Controllers\FilesController@update')->name('file.update');
	Route::get('/remove/{id}', 'App\Http\Controllers\FilesController@destroy')->name('file.remove');
	Route::get('/download/{id}', 'App\Http\Controllers\FilesController@download')->name('files.download');
	Route::get('/edit/{id}', 'App\Http\Controllers\FilesController@editPage')->name('file.edit');
	Route::get('/share/{id}', 'App\Http\Controllers\FilesController@generatePublicLink')->name('file.share');
	

	Route::get('/create-folder', 'App\Http\Controllers\FolderController@createFolderPage')->name('folder.create');
	Route::get('/files/folder/{id}', 'App\Http\Controllers\FilesController@folderFiles')->name('files.folder');
});

require __DIR__.'/auth.php';
