<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slider','seo','phone','social','delivery_info','work','email','bonus_percent'
    ];

}
