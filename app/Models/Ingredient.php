<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'title','category_id','image','part_2','part_1'
    ];

    public function category() {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
}
