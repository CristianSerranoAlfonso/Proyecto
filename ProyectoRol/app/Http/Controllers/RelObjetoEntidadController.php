<?php

namespace App\Http\Controllers;

use App\Models\Rel_objeto_entidad;
use App\Models\Entidad;
use Illuminate\Http\Request;

class RelObjetoEntidadController extends Controller
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
     * @param  \App\Models\Rel_objeto_entidad  $rel_objeto_entidad
     * @return \Illuminate\Http\Response
     */
    public function show(Rel_objeto_entidad $rel_objeto_entidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rel_objeto_entidad  $rel_objeto_entidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Rel_objeto_entidad $rel_objeto_entidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rel_objeto_entidad  $rel_objeto_entidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rel_objeto_entidad $rel_objeto_entidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rel_objeto_entidad  $rel_objeto_entidad
     * @return \Illuminate\Http\Response
     */
   
    public function borrar($id, Request $request)
    {
        $entrada = $request->all();
        $idEntidad = $entrada['entidad'];
        $entidad = Entidad::find($idEntidad);
        $entidad->objetos()->detach($id);
        
    }
}
