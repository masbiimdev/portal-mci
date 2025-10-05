<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobcardHistory extends Model
{

    protected $fillable = [
        'jobcard_id',
        'process_name',
        'action',
        'scanned_by',
        'scanned_at',
        'remarks',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    // Relasi ke jobcard
    public function jobcard()
    {
        return $this->belongsTo(Jobcard::class);
    }

    // Relasi ke user yang scan
    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
