<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Materia;
use App\Calificacion;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CalificacionController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Desplegar alumnos
    	$alumnos = Alumno::all();

    	return response()->json(['alumnos' => $alumnos], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1) Valida datos
        $validator = \Validator::make($request->all(), [
            'id_t_usuarios' => 'required|exists:t_alumnos,id_t_usuarios',
            'id_t_materias' => 'required|exists:t_materias,id_t_materias',
            'calificacion' => 'required|numeric|between:0,10.00',
        ]);

        // 1.1) Si el validador falla
        if ($validator->fails()) {
            \Log::info('Error:');
            \Log::info($validator->errors());

            return response()->json([
        						'success' => 'false',
        						'msg' => $validator->errors()
        			], 400);
        }

        // Registra calificacion
        $calificacion = new Calificacion();
        $calificacion->id_t_usuarios = $request->id_t_usuarios;
        $calificacion->id_t_materias = $request->id_t_materias;
        $calificacion->calificacion = $request->calificacion;
        $calificacion->fecha_registro = $this->fecha_actual();
        $calificacion->save();

        return response()->json([
        						'success' => 'ok',
        						'msg' => 'calificacion registrada'
        			], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	// Validar que el alumno exista
        if (!Alumno::find($id)) {
        	return response()->json([
        						'success' => 'false',
        						'msg' => 'Este usuario no existe.'
        			], 400);
        }

        // Validar que el alumno tenga calificaciones asignadas
        if (count(Calificacion::where('id_t_usuarios', $id)->get()) == 0) {
        	return response()->json([
        						'success' => 'false',
        						'msg' => 'No se han registrado calificaciones para el usuario.'
        			], 400);
        }

    	// Obtiene datos del alumnos
    	$alumno_materia = Calificacion::join('t_alumnos', 't_calificaciones.id_t_usuarios', '=', 't_alumnos.id_t_usuarios')
    								->join('t_materias', 't_calificaciones.id_t_materias', '=', 't_materias.id_t_materias')
    								->where('t_calificaciones.id_t_usuarios', $id)
    								->select('t_alumnos.id_t_usuarios', 't_alumnos.nombre AS nombre', \DB::raw("CONCAT(t_alumnos.ap_paterno, ' ', t_alumnos.ap_materno) AS apellido"), 't_materias.nombre AS materia', 't_calificaciones.calificacion', \DB::raw("DATE_FORMAT(t_calificaciones.fecha_registro, '%d/%m/%Y') AS fecha_registro"))
    								->get();

    	// Obtiene el promedio de sus calificaciones
    	$promedio = Calificacion::where('id_t_usuarios', $id)->avg('calificacion');

    	// Añade el promedio a la respuesta
    	$alumno_materia['promedio'] = $promedio;

        return response()->json([
        						'calificaciones_alumno' => $alumno_materia
        			], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       	// 1) Valida datos ingresados
        $validator = \Validator::make($request->all(), [
            'id_t_usuarios' => 'required',
            'id_t_materias' => 'required',
            'calificacion' => 'required|numeric|between:0,10.00',
        ]);

        // 1.1) Si el validador falla
        if ($validator->fails()) {
            \Log::info('Error:');
            \Log::info($validator->errors());

            return response()->json([
        						'success' => 'false',
        						'msg' => $validator->errors()
        			], 400);
        }

        // Validar que exista un registro de calificación 
        $calificacion = Calificacion::where('id_t_usuarios', $request->id_t_usuarios)
        							->where('id_t_materias', $request->id_t_materias)
        							->first();

    	// El registro no existe
        if (!$calificacion) {
        	return response()->json([
        						'success' => 'false',
        						'msg' => 'Aún no se ha registrado una calificación para este alumno.'
        			], 400);
        }

        // Actualiza registro de calificación
        $calificacion->calificacion = $request->calificacion;
        $calificacion->fecha_registro = $this->fecha_actual();
        $calificacion->save();

       	return response()->json([
        						'success' => 'ok',
        						'msg' => 'calificacion actualizada'
        			], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // 1) Valida datos ingresados
        $validator = \Validator::make($request->all(), [
            'id_t_usuarios' => 'required',
            'id_t_materias' => 'required'
        ]);

        // 1.1) Si el validador falla
        if ($validator->fails()) {
            \Log::info('Error:');
            \Log::info($validator->errors());

            return response()->json([
        						'success' => 'false',
        						'msg' => $validator->errors()
        			], 400);
        }

        // Validar que exista un registro de calificación 
        $alumno = Alumno::where('id_t_usuarios', $request->id_t_usuarios)->first();

        // El registro no existe
        if (!$alumno) {
        	return response()->json([
        						'success' => 'false',
        						'msg' => 'El alumno no existe.'
        			], 400);
        }

        // Validar que exista un registro de calificación 
        $calificacion = Calificacion::where('id_t_usuarios', $request->id_t_usuarios)
        							->where('id_t_materias', $request->id_t_materias)
        							->first();

    	// El registro no existe
        if (!$calificacion) {
        	return response()->json([
        						'success' => 'false',
        						'msg' => 'Aún no se ha registrado una calificación para este alumno.'
        			], 400);
        }

        // Actualiza registro de calificación
        $calificacion->delete();

       	return response()->json([
        						'success' => 'ok',
        						'msg' => 'calificacion eliminada'
        			], 200);
    }

    /**
     * Devuelve la fecha del día de hoy
     */
    public function fecha_actual()
    {
    	return Carbon::today()->toDateString();
    }
}
