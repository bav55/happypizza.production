<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bonus_log extends Model
{
    protected $table = 'bonus_log';

    public $timestamps = true;

    protected $fillable = [
        'order_id','user_id','bonus','notes','referal_id'
    ];

	
	public function getOrder(){
        return $this->hasOne('App\Models\Order', 'order_id', 'id');
    }
}
