<?php

namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;

class Configuration extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = ['key','value'];
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
     }
}
