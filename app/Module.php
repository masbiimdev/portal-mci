<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name', 'slug', 'route_name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'module_user', 'module_id', 'user_id');
    }
}
