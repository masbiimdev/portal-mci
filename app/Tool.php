<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = [
        'nama_alat',
        'merek',
        'no_seri',
        'kapasitas',
        'qr_token',
        'qr_code_path'
    ];

    // Semua riwayat kalibrasi
    public function histories()
    {
        return $this->hasMany(CalibrationHistory::class, 'tool_id');
    }

    // History paling terbaru (Laravel 7)
    public function latestHistory()
    {
        return $this->hasOne(CalibrationHistory::class, 'tool_id')
                    ->orderBy('tgl_kalibrasi', 'desc');
    }
}
