<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'is_show','message','name','phone','rating','sort','is_look'
    ];
}
