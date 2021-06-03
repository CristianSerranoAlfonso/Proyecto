<?php

namespace App\Http\Controllers;

use App\Models\Tirada;
use App\Models\Escenario;
use App\Models\Habilidad;
use App\Models\Entidad;

use Illuminate\Http\Request;

class TiradaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addTirada(Request $request, $id) 
    {
        $datos = $request->all();

        $entidades = Entidad::All();

        //Almacenamos la entidad que lanza la habilidad
        foreach ($entidades as $entidad) {
            if($entidad->nombre == $datos['entidad']) {
                $idLanza = $entidad->id;
                $nombreLanza = $entidad->nombre;
            }
        }

        //Almacenamos la habilidad
        $habilidad = Habilidad::find($datos['habilidad']);

        //Almacenamos la tirada
        $valor = $datos['tirada'];

        //Almacenamos el/los foco/s
        $entidadFoco = "";
        foreach ($entidades as $entidad) {
            foreach($datos['foco'] as $foco) {
                if($foco == $entidad->id) {
                    $entidadFoco .= $entidad->nombre . "-";
                }
            }
        }
        $entidadFoco = trim($entidadFoco, "-");
        $datosTirada = ['idEscenario'=>$id, 'idEntidad'=> $idLanza, 'idHabilidad' => $datos['habilidad'], 'tirada'=>$datos['tirada'], 'foco'=>$entidadFoco];     
        $tirada = Tirada::create($datosTirada);
        $msj = "<b>$nombreLanza</b>\n ha lanzado la habilidad $habilidad->nombre a <b>$entidadFoco</b> y el valor de su tirada ha sido $valor. \n <hr>";
        return response()->json($msj, 200);


    }
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tirada  $tirada
     * @return \Illuminate\Http\Response
     */
    public function show(Tirada $tirada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tirada  $tirada
     * @return \Illuminate\Http\Response
     */
    public function edit(Tirada $tirada)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tirada  $tirada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tirada $tirada)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tirada  $tirada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tirada $tirada)
    {
        //
    }
}
