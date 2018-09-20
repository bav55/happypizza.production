<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title','image','excerpt','content','seo_title','seo_description','seo_keywords','url'
    ];

}
