<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    // Definifir la tabla a la cual hará referencia el modelo
    protected $table = 't_calificaciones';

    // Modificar llave primaria
    protected $primaryKey = 'id_t_calificaciones';

    // Desactivar timestamps
    public $timestamps  = false;

    public $dateFormat = 'dd/mm/yyyy';

    // Valores que serán llenados
    protected $fillable = ['id_t_materias', 'id_t_usuarios', 'calificacion', 'fecha_registro']; 
}