<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;

class NewsComment extends Model
{

    protected $connection = 'mongodb';

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
     }
}
