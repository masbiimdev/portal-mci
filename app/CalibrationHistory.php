<?php

namespace App;

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

    /* ============================================================
       AUTO FILL KETERANGAN DARI STATUS (TRIGGERED EVERY UPDATE)
    ============================================================ */
    public function setStatusKalibrasiAttribute($value)
    {
        // Normalisasi status
        $status = strtoupper($value);

        if (!in_array($status, ['OK', 'PROSES', 'DUE SOON'])) {
            $status = 'PROSES';
        }

        $this->attributes['status_kalibrasi'] = $status;

        // Auto-generate keterangan (selalu overwrite)
        if ($status === 'OK') {
            $this->attributes['keterangan'] = 'Alat telah dikalibrasi Sesuai Standar dan siap untuk digunakan.';
        } elseif ($status === 'PROSES') {
            $this->attributes['keterangan'] = 'Proses kalibrasi sedang berlangsung.';
        } elseif ($status === 'DUE SOON') {
            $this->attributes['keterangan'] = 'Kalibrasi mendekati jatuh tempo (<30 hari). Harap segera menjadwalkan kalibrasi ulang untuk mencegah overdue.';
        }
    }
}
