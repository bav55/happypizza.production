<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{

    protected $table = 'mailings';

    protected $fillable = [
        'mail_to','mail_title','mail_content'
    ];

}
