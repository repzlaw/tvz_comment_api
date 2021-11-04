<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $connection = 'mysql';

    protected $fillable = ['key','value'];
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
     }
}
