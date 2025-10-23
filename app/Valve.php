<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valve extends Model
{
    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'valve_code',
        'valve_name',
        'description',
    ];

    /**
     * Relasi ke tabel materials.
     * Satu valve bisa digunakan oleh banyak material.
     */
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_valve');
    }
}
