<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $timestamps = false;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre', 'indicativo', 'whatsapp', 'codigo',
    ];

    // Relaciones
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_usuario');
    }
}
