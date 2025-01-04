<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    public $timestamps = false;

    protected $table = 'grupos';

    protected $fillable = [
        'id_sala', 'id_usuario', 'id_usuario_corresponde',
    ];

    // Relaciones
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'id_sala');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function usuarioCorresponde()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_corresponde');
    }
}
