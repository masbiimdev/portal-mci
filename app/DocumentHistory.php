<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentHistory extends Model
{
    protected $table = 'document_histories';

    protected $fillable = [
        'document_id',
        'action',
        'revision',
        'note',
        'user_id',
        'created_at', // tambahkan supaya bisa diisi manual
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public $timestamps = false; // <-- matikan timestamps otomatis

    /* ================= RELATION ================= */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
