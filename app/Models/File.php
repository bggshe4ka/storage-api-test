<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'path',
        'size',
        'folder_id',
        'user_id'
    ];

    /**
     * Getting total file size in cloud
     * 
     * @return int
     */
    public static function getSizeOfAllFiles() {
    	$files = Storage::disk('public')->allFiles();
        $file_size = 0;
        foreach ($files as $file) {
             $file_size += Storage::disk('public')->size($file);
        }
        $file_size = round($file_size / 1024 / 1024, 2);

        return $file_size;
    }
}