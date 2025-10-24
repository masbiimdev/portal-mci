<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    protected $fillable = [
        'type',
        'start_date',
        'end_date',
        'kegiatan',
        'customer',
        'po',
        'items',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(ActivityItemResult::class, 'activity_id', 'id');
    }
}
