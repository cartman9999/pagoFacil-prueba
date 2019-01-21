<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    // Definifir la tabla a la cual hará referencia el modelo
    protected $table = 't_materias';

    // Modificar llave primaria
    protected $primaryKey = 'id_t_materias';

    // Desactivar timestamps
    public $timestamps  = false;

    // Valores que serán llenados
    protected $fillable = ['nombre', 'activo'];
}
