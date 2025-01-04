<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    public $timestamps = false;

    protected $table = 'salas';

    protected $fillable = [
        'nombre', 'descripcion', 'fecha_limite', 'codigo', 'id_creador',
    ];

    // Relaciones
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_sala');
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'id_creador');
    }
}
