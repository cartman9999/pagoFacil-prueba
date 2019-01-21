<?php

namespace App\Http\Controllers\Api;

use App\Alumno;
use App\Materia;
use App\Calificacion;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    	$alumnos = \App\Alumno::all();

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
            // return redirect()->back()->withErrors($validator)->withInput($request->all);
            return response()->json([
        						'success' => 'false',
        						'msg' => $validator->errors()
        			], 400);
        }

        // Obtiene fecha
        $fecha_actual = Carbon::today()->toDateString();

        // Registra calificacion
        $calificacion = new \App\Calificacion();
        $calificacion->id_t_usuarios = $request->id_t_usuarios;
        $calificacion->id_t_materias = $request->id_t_materias;
        $calificacion->calificacion = $request->calificacion;
        $calificacion->fecha_registro = $fecha_actual;
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
    	// \App\Alumno
    	// \App\Calificacion
    	$promedio = \App\Calificacion::where($id, 'id_t_materias')->avg('calificacion');

        return response()->json([
        						'promedio' => $promedio 
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
