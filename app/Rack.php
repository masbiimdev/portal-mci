<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    protected $fillable = [
        'rack_code',
        'rack_name',
        'description',
    ];

    /**
     * Relasi ke Material (satu rack bisa punya banyak material)
     */
    public function materials()
    {
        return $this->hasMany(Material::class, 'rack_id');
    }
}
