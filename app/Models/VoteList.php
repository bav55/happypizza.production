<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteList extends Model
{

    protected $table = 'vote_lists';

    protected $fillable = [
        'vote_id','vote','title','sort'
    ];

    public $timestamps = false;


}
