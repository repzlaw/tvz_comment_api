<?php

namespace App\Models;

use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;

class ReportedPlayerComment extends Model
{
    protected $connection = 'mongodb';

     /**
     * Get comment details.
     */
    public function comment()
    {
        return $this->belongsTo(PlayerComment::class);
    }
    
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
     }
}
