<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portion extends Model
{
    protected $fillable = [
        'title'
    ];

    public static function getPortionID($portion){
        return $portion->id;
    }

    public static function getPortionName($portion) {
        return $portion->title;
    }
}
