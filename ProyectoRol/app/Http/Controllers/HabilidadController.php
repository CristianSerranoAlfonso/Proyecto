<?php

namespace App\Http\Controllers;

use App\Models\Habilidad;
use App\Models\Rel_entidad_habilidad;
use Auth;
use Exception;
use Illuminate\Http\Request;

class HabilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $habilidades = Habilidad::All();
        $contador = 0;
        $habilidadesMandar = [];
        foreach ($habilidades as $habilidad) {
            if ($habilidad->usuario_id == Auth::user()->id) {
                $habilidadesMandar[$contador] = $habilidad;
                $contador++;
            }
        }
        return view("habilidad.listar", ['habilidades'=>$habilidadesMandar]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("habilidad.crear");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entrada = $request->all();
        // Comprobamos si existen facultades negativas o positivas
        if ($entrada['facultadN'] == "null") {
            $facultadNB = 0;
        } else {
            $facultadNB = $entrada['facultadNB'];
        }

        // Comprobamos si es un ataque en área o no
        if ($entrada['area'] == "no") {
            $area = FALSE;
        } else {
            $area = TRUE;
        }

        //Comprobamos si es un ataque o una curación
        if ($entrada['tipo'] == "cura") {
            $tipo = FALSE;
        } else {
            $tipo = TRUE;
        }
         // Almacenamos en un array todos los datos para crear la entidad
         $datosHabilidad = ['nombre'=>$entrada['nombre'], 'facultadNegativa'=>$entrada['facultadN'], 'baseFacultadNegativa'=>$facultadNB,
          'facultadPositiva'=>$entrada['facultadP'], 'nivelHabilidad'=>$entrada['nivel'],
           'dado'=>$entrada['dado'],'valorBase'=>$entrada['valor'], 'ataque'=>$tipo,'area'=>$area,
            'usuario_id'=>Auth::user()->id];
        
        // Controlamos que no haya un error 1062 (entrada unique duplicada) mediante el try catch
        try{ 
            Habilidad::create($datosHabilidad);
        }catch(Exception $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return view("habilidad.crear", "Ya existe una habilidad con ese nombre");
            } else {
                dd($e);
            }
        }
        return redirect()->route('habilidad.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Habilidad  $habilidad
     * @return \Illuminate\Http\Response
     */
    public function show(Habilidad $habilidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Habilidad  $habilidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Habilidad $habilidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Habilidad  $habilidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Habilidad $habilidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Habilidad  $habilidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Habilidad $habilidad)
    {
        $borrar = true;
        $habilidadesEntidades = Rel_entidad_habilidad::All();
        foreach($habilidadesEntidades as $habilidadE){
            if ($habilidadE->habilidad_id == $habilidad->id) {
                $borrar = false;
            }
        }
        if ($borrar) {
            $habilidad->delete();
            return "borrado";
        } else {
            return "no";
        }
    }
}
