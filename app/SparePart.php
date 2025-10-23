<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
        protected $fillable = [
        'spare_part_code',
        'spare_part_name',
        'description',
    ];
}
