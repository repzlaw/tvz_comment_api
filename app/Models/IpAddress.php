<?php

namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;

class IpAddress extends Model
{
    protected $connection = 'mongodb';

    protected $fillable = ['ip_address'];
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
     }
}
