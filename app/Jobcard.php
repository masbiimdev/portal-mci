<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobcard extends Model
{

    protected $fillable = [
        'jobcard_no',
        'ws_no',
        'customer',
        'serial_no',
        'drawing_no',
        'disc',
        'body',
        'bonnet',
        'size_class',
        'type',
        'qty_acc_po',
        'date_line',
        'category',
        'created_by',
    ];

    protected $casts = [
        'date_line' => 'date',
    ];

    // Relasi ke user pembuat
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke history scan
    public function histories()
    {
        return $this->hasMany(JobcardHistory::class);
    }
}
