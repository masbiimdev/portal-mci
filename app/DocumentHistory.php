<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentHistory extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'document_id', 'action', 'revision', 'note', 'user_id', 'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // SCOPES
    public function scopeDownloaded($query)
    {
        return $query->where('action', 'downloaded');
    }

    public function scopeForDocument($query, $documentId)
    {
        return $query->where('document_id', $documentId);
    }

    // DOWNLOAD STATISTICS
    public static function getDownloadCount($documentId): int
    {
        return self::forDocument($documentId)->downloaded()->count();
    }

    public static function getUniqueDownloaders($documentId): int
    {
        return self::forDocument($documentId)->downloaded()->distinct('user_id')->count('user_id');
    }

    public static function getLastDownloadTime($documentId)
    {
        $record = self::forDocument($documentId)->downloaded()->latest('created_at')->first();
        return $record ? $record->created_at : null;
    }

    public static function getDownloadedByUsers($documentId)
    {
        return self::forDocument($documentId)
            ->downloaded()
            ->with('user')
            ->latest('created_at')
            ->get()
            ->groupBy('user_id')
            ->map(function ($downloads) {
                return [
                    'user' => $downloads->first()->user,
                    'count' => $downloads->count(),
                    'last_download' => $downloads->first()->created_at,
                ];
            })
            ->values(); // numeric index supaya Blade loop aman
    }
}
