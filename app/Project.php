<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'document_projects';

    protected $fillable = [
        'project_code',
        'project_number',
        'project_name',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    /* ================= RELATION ================= */

    public function folders()
    {
        return $this->hasMany(Folder::class, 'document_project_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'document_project_id');
    }
}
