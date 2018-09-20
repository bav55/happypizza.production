<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good_Size_Price extends Model
{

    protected $table = 'good__size__prices';

    protected $fillable = [
        'good_id','portion_id','portion_price'
    ];

    public function portion() {
        return $this->hasOne('App\Models\Portion', 'id', 'portion_id');
    }

}
