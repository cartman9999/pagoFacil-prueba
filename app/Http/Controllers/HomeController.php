<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Calificacion;
use App\Materia;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	/**
	 * Devuelve la vista inicial
	 */
    public function index()
    {
    	// Obtiene materias
    	$materias = Materia::all();

    	// Obtiene datos para Tabla 2 - Alumnos
    	$alumnos = Alumno::all();
    	$alumnos_promedio = $this->tabla2_alumnos();

    	// Obtiene Datos para Tabla 3 - Materia
    	$array_materias = $this->tabla3_materias();

    	return view('welcome')->with(compact('materias'))
    							->with(compact('alumnos'))
    							->with(compact('alumnos_promedio'))
    							->with(compact('array_materias'));
    }

    /**
     * Obtiene los datos para generar la segunda tabla con datos de los alumnos
     */
    public function tabla2_alumnos()
    {
    	// Obtiene Alumnos
    	$alumnos = Alumno::all();

    	$posicion=0;
    	foreach ($alumnos as $alumno) {
    		// Obtiene el promedio de sus calificaciones y número de materias
    		$promedio = Calificacion::where('id_t_usuarios', $alumno->id_t_usuarios)->avg('calificacion');
    		$num_materias = Calificacion::where('id_t_usuarios', $alumno->id_t_usuarios)->count();

    		$alumnos_promedio[$posicion]['nombre'] = $alumno->nombre;
    		$alumnos_promedio[$posicion]['apellido'] = $alumno->ap_paterno . ' ' . $alumno->ap_materno;
    		$alumnos_promedio[$posicion]['estatus'] = $alumno->activo;
    		$alumnos_promedio[$posicion]['num_materias'] = ($num_materias) ? $num_materias : '-';
    		$alumnos_promedio[$posicion]['promedio'] = ($promedio) ? number_format((float)$promedio, 2, '.', '') : '-';

    		$posicion++;
    	}

    	return $alumnos_promedio;
    }

    /**
     * Obtiene los datos para generar la tercer tabla - Calificaciones por materia
     */
    public function tabla3_materias()
    {
    	// Obtiene todas las materias registradas
    	$materias = Materia::all();

    	$posicion=0;
    	foreach ($materias as $materia) {
    		// Obtener alumnos asignados a la materia
    		$array_alumnos_materia = Calificacion::where('id_t_materias', $materia->id_t_materias)
    											->get(['id_t_usuarios']);

    		$alumnos_materia = Alumno::whereIn('id_t_usuarios', $array_alumnos_materia)->get();

    		foreach ($alumnos_materia as $alumno_materia) {
    			// Obtiene la calificación del alumno en la materia
    			$calificacion = Calificacion::where('id_t_usuarios', $alumno_materia->id_t_usuarios)
    										->where('id_t_materias', $materia->id_t_materias)
    										->first();

    			// Genera la respuesta
    			$array_materias[$materia->nombre][$posicion]['nombre'] = $alumno_materia->nombre;
    			$array_materias[$materia->nombre][$posicion]['apellido'] = $alumno_materia->ap_paterno . ' ' . $alumno_materia->ap_materno;
    			$array_materias[$materia->nombre][$posicion]['calificacion'] = $calificacion->calificacion;
    			$array_materias[$materia->nombre][$posicion]['fecha'] = $calificacion->fecha_registro;
    			
    			$posicion++; 
    		}
    		// Reinicia posición para una nueva materia
    		$posicion=0;
    	}

    	return $array_materias;
    }
}
