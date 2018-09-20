<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected $fillable = [
        'title','image','excerpt','content','seo_title','seo_description','seo_keywords','url'
    ];

}
