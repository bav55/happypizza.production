<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $fillable = [
        'title','url','image','excerpt','content','sort','form','is_show'
    ];
}
