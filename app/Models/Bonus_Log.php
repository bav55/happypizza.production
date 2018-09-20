<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bonus_log extends Model
{

    protected $table = 'bonus_log';

    public $timestamps = false;

    protected $fillable = [
        'order_id','user_id','bonus'
    ];

	
	public function getOrder(){
        return $this->hasOne('App\Models\Order', 'order_id', 'id');
    }
}
