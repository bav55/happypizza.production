<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCod extends Model
{

    protected $table = 'promo_cods';

    protected $fillable = [
        'title','limit','sum','is_percent','is_sum','comment','apply'
    ];


}
