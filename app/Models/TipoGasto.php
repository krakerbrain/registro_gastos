<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoGasto extends Model
{
    use HasFactory;
    protected $fillable = ['descripcion'];

    public static function buscarPorDescripcion($descripcion)
{
    return TipoGasto::where('descripcion', $descripcion)
                   ->first();
}
}
