<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $table = 'document_folders';

    protected $fillable = [
        'document_project_id',
        'folder_name',
        'folder_code',
        'description',
    ];

    /* ================= RELATION ================= */

    public function project()
    {
        return $this->belongsTo(Project::class, 'document_project_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'document_folder_id');
    }
}
