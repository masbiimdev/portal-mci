<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'material_code',
        'valve_id',
        'spare_part_id',
        'no_drawing',
        'heat_lot_no',
        'dimensi',
        'stock_awal',
        'stock_minimum',
        'rack_id',
        // 'material_name'
    ];

    public function valves()
    {
        return $this->belongsToMany(Valve::class, 'material_valve');
    }


    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }
    public function incomings()
    {
        return $this->hasMany(MaterialIn::class);
    }

    public function outgoings()
    {
        return $this->hasMany(MaterialOut::class);
    }

    public function getCurrentStockAttribute()
    {
        return $this->stock_awal
            + $this->incomings()->sum('qty_in')
            - $this->outgoings()->sum('qty_out');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
