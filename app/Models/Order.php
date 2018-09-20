<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';

    protected $fillable = [
        'user_id','name','phone','email','delivery_type_id','delivery_zone_id','delivery_address','pay_type_id','extra','is_paid','good_list','present_list','bonus_sum','apply_bonus_sum','order_id','transaction_id','order_sum','is_new'
    ];

    
    public function getBonusLog(){
        return $this->hasOne('App\Models\Bonus_Log', 'order_id', 'id');
    }
}
