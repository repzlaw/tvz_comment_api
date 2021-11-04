<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    protected $connection = 'mysql';

    protected $fillable = ['ip_address'];
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
     }
}
