<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialOut extends Model
{
    protected $table = 'material_out'; // pastikan ini pakai nama tabel yang benar
    protected $fillable = [
        'material_id',
        'valve_id',
        'qty_out',
        'date_out',
        'notes',
        'user_id',
        'stock_after'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
