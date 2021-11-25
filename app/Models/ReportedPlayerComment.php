<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class ReportedPlayerComment extends Model
{
    use HybridRelations;
    protected $connection = 'mysql';

     /**
     * Get comment details.
     */
    public function comment()
    {
        return $this->setConnection('mongodb')->belongsTo(PlayerComment::class);
    }
    
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
     }
}
