<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ncr extends Model
{
    // Tambahkan SoftDeletes di dalam use di atas jika pakai fitur soft delete (use HasFactory, SoftDeletes;)

    /**
     * Nama tabel yang terkait dengan model ini.
     * (Opsional jika nama tabel Anda sudah plural dari nama model, yaitu 'ncrs')
     */
    protected $table = 'ncrs';

    /**
     * Kolom-kolom yang diizinkan untuk diisi secara massal (Mass Assignment).
     * Sangat penting untuk keamanan agar user tidak bisa memanipulasi kolom lain.
     */
    protected $fillable = [
        'no_ncr',
        'issue_date',
        'issue',
        'audit_scope',
        'severity',
        'status',
    ];

    /**
     * Konversi tipe data (Casting).
     * Memastikan issue_date otomatis diperlakukan sebagai objek Carbon (Tanggal/Waktu)
     * sehingga mudah di-format di Blade view, misalnya: $ncr->issue_date->format('d M Y')
     */
    protected $casts = [
        'issue_date' => 'date',
    ];
}
