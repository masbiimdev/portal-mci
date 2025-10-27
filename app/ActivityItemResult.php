<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityItemResult extends Model
{
    protected $fillable = [
        'activity_id',
        'part_name',
        'material',
        'qty',
        'inspector_name',
        'pic',
        'inspection_time',
        'result',
        'status',
        'remarks',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
