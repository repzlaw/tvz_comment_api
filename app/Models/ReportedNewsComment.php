<?php

namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;

class ReportedNewsComment extends Model
{
    protected $connection = 'mongodb';

     /**
     * Get comment details.
     */
    public function comment()
    {
        return $this->belongsTo(NewsComment::class);
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
     }
}
