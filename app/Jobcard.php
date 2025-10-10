<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobcard extends Model
{

    protected $fillable = [
        'jobcard_id',
        'no_joborder',     // No Job Order
        'ws_no',
        'customer',
        'type_jobcard',     // Jobcard Machining / Assembling
        'type_valve',
        'size_class',
        'drawing_no',
        'remarks',
        'detail',
        'batch_no',
        'material',
        'qty',
        'part_name',
        'serial_no',
        'body',
        'bonnet',
        'disc',
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

    public static function categories()
    {
        return ['reused', 'new manufacture', 'repair', 'supplied'];
    }
}
