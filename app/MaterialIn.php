<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialIn extends Model
{
    protected $table = 'material_in'; // pastikan ini pakai nama tabel yang benar
    protected $fillable = [
        'material_id',
        'date_in',
        'qty_in',
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
