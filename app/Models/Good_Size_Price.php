<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Good_Size_Price extends Model
{

    protected $table = 'good__size__prices';

    protected $fillable = [
        'good_id','portion_id','portion_price','frontpad_article','frontpad_title'
    ];

    public function portion() {
        return $this->hasOne('App\Models\Portion', 'id', 'portion_id');
    }
    public function good(){
        return $this->hasOne('App\Models\Good', 'id', 'good_id');
    }
    public static function getGoodName($good){
        return $good->title;
    }
    public static function getPortionName($portion){
        return $portion->title;
    }
}
