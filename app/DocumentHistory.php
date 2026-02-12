<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentHistory extends Model
{
    public $timestamps = false;

    protected $table = 'document_histories';

    protected $fillable = [
        'document_id',
        'action',
        'revision',
        'note',
        'user_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

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
