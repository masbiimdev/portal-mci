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
