<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mediafile extends Model
{

    protected $fillable = [
        'name', 'url','type'
    ];

}
