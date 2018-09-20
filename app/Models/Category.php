<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'title', 'url','seo_title','seo_description','seo_keywords','content','image_path','position'
    ];

    public static function getCategoryName($category){
        return $category->title;
    }

    public static function getCategoryId($category){
        return $category->id;
    }

}
