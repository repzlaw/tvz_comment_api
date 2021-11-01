<?php

namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;

class NewsCommentUpvote extends Model
{
    protected $connection = 'mongodb';

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
     }
}
