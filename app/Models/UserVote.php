<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVote extends Model
{

    protected $table = 'user_votes';

    protected $fillable = [
        'vote_id','user_ip'
    ];

    public $timestamps = false;

    public static function getUserVoteIP($ip){
        return UserVote::where('user_ip',$ip)->get()->toArray() ? UserVote::where('user_ip',$ip)->get() : null;

    }

}
