<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_bonus extends Model
{

    protected $table = 'user_bonuses';

    public $timestamps = false;

    protected $fillable = [
        'user_id','bonus'
    ];

}
