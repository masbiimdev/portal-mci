<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annon extends Model
{
    protected $table = 'announcements';
    protected $fillable = [
        'title',
        'content',
        'author_id',
        'type',
        'department',
        'priority',
        'attachment',
        'expiry_date',
        'is_active'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
