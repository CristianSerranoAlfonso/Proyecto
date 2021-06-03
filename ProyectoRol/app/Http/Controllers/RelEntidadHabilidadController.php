<?php

namespace App\Http\Controllers;

use App\Models\Rel_entidad_habilidad;
use App\Models\Entidad;
use Illuminate\Http\Request;

class RelEntidadHabilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     * @param  \App\Models\Rel_entidad_habilidad  $rel_entidad_habilidad
     * @return \Illuminate\Http\Response
     */
    public function show(Rel_entidad_habilidad $rel_entidad_habilidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rel_entidad_habilidad  $rel_entidad_habilidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Rel_entidad_habilidad $rel_entidad_habilidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rel_entidad_habilidad  $rel_entidad_habilidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rel_entidad_habilidad $rel_entidad_habilidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rel_entidad_habilidad  $rel_entidad_habilidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rel_entidad_habilidad $rel_entidad_habilidad)
    {
        //
    }
    public function borrar($id, Request $request)
    {
        $entrada = $request->all();
        $idEntidad = $entrada['entidad'];
        $entidad = Entidad::find($idEntidad);
        $entidad->habilidades()->detach($id);
        
    }
}
