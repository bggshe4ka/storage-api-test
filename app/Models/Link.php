<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'file_id'
    ];

    /**
     * Getting a link to download a public file
     * @param  int  $file_id
     * @return string
     */
    public static function checkLinkExists($file_id) {
    	$link_model = Link::where('file_id', $file_id)->first();
    	return  '/dl/'.$link_model->slug;
    }
}
