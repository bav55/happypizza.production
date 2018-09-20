<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{

    protected $table = 'votes';

    protected $fillable = [
        'title','sort','image','is_show','user_ip'
    ];

    public $timestamps = false;

    public function getVoteList(){
        return $this->hasMany('App\Models\VoteList', 'vote_id', 'id');
    }

    public function getVoteIP(){
        return $this->hasMany('App\Models\UserVote', 'vote_id', 'id');
    }

}
