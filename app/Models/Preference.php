<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = [
        'title','category_id'
    ];

    public function category() {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }
}
