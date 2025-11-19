<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CalibrationHistory extends Model
{

    protected $table = 'calibration_histories';

    protected $fillable = [
        'tool_id',
        'tgl_kalibrasi',
        'tgl_kalibrasi_ulang',
        'no_sertifikat',
        'file_sertifikat',
        'lembaga_kalibrasi',
        'interval_kalibrasi',
        'eksternal_kalibrasi',
        'status_kalibrasi',
        'keterangan'
    ];

    protected $dates = [
        'tgl_kalibrasi',
        'tgl_kalibrasi_ulang',
        'created_at',
        'updated_at'
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function remainingDays()
    {
        if (!$this->tgl_kalibrasi_ulang) return null;
        return Carbon::now()->diffInDays($this->tgl_kalibrasi_ulang, false);
    }
}
