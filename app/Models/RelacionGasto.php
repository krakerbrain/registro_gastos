<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacionGasto extends Model
{
    use HasFactory;

    protected $table = 'descripcion_gasto_gasto';

    protected $fillable = [
        'descripcion_gasto_id',
        'gasto_id'
    ];

}
