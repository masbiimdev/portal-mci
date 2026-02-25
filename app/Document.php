<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'document_project_id',
        'document_folder_id',
        'document_no',
        'title',
        'revision',
        'file_path',
        'is_final',
    ];

    protected $casts = [
        'is_final' => 'boolean',
    ];

    /* ================= RELATION ================= */

    public function histories()
    {
        return $this->hasMany(DocumentHistory::class)
            ->orderByDesc('created_at');
    }

    public function latestHistory()
    {
        return $this->hasOne(DocumentHistory::class)
            ->latestOfMany('created_at');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'document_project_id');
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'document_folder_id');
    }

    /* ================= ACCESSOR ================= */

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
