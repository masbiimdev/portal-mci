<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $table = 'stock_opname'; // ← tambahkan ini

    protected $fillable = [
        'material_id',
        'date_opname',
        'stock_system',
        'stock_actual',
        'selisih',
        'warning',
        'notes',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
