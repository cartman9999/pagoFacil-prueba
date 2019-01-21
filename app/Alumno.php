<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    // Definifir la tabla a la cual hará referencia el modelo
    protected $table = 't_alumnos';

    // Modificar llave primaria
    protected $primaryKey = 'id_t_usuarios';

    // Desactivar timestamps
    public $timestamps  = false;

    // Valores que serán llenados
    protected $fillable = ['nombre', 'ap_paterno', 'ap_materno', 'activo'];    
}
