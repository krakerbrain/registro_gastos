<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gastos extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion',
        'monto_gasto',
        'tipo_gasto_id',
        'descripcion_gasto_id',
        'created_at'
    ];

    public function tipoGasto()
    {
        return $this->belongsTo(TipoGasto::class);
    }
    public function descripcionGastos()
    {
        return $this->hasMany(DescripcionGasto::class);
    }

}
