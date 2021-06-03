<?php

namespace App\Http\Controllers;

use App\Models\Objeto;
use App\Models\Rel_objeto_entidad;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Exception;

class ObjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objetos = Objeto::All();
        $objetosUsuario = [];
        $contador = 0;
        foreach($objetos as $objeto) {
            if ($objeto->idUsuario == Auth::user()->id) {
                $objetosUsuario[$contador] = $objeto;
                $contador++;
            }
        }
        return view('objeto.listar', ['objetos'=>$objetosUsuario]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('objeto.crear');
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
        if($archivo = $request->file('imagen')) {
            // Creamos la ruta para la imagen en el caso de que sea una imagen lo que se ha subido
            $extension = explode('/', $archivo->getClientMimeType());
            if ($extension[0] != "image") {
               return redirect()->route('personaje.index', ['msj' => "No se ha subido la img"]);
            }
            $carpeta = "imagenes/objeto";
            $nombre = $entrada['nombre'].'.'.$extension[1];
            $nombreBase = $carpeta . '/'.$nombre;

            // Almacenamos en un array todos los datos para crear la entidad
            $datosObjeto = ['idUsuario'=> Auth::user()->id, 'nombre'=>$entrada['nombre'], 'rango'=>$entrada['rango'], 'tipo'=>$entrada['tipo'], 'armadura'=>$entrada['armadura'], 'fuerza'=>$entrada['fuerza'], 'destreza'=>$entrada['destreza'], 'inteligencia'=>$entrada['inteligencia'], 'cordura'=>$entrada['cordura'], 'sabiduria'=>$entrada['sabiduria'],'evasion'=>$entrada['evasion'], 'precio'=>$entrada['precio'],'descripcion'=>$entrada['descripcion'],'imagen'=>$nombreBase];

            // Controlamos que no haya un error 1062 (entrada unique duplicada) mediante el try catch
            try{ 
                $objeto = Objeto::create($datosObjeto);
            }catch(Exception $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return view("objeto.crear");
                }
            }
            //Movemos la imagen a la carpeta
            $archivo->move($carpeta, $nombre);
        } 
        return redirect()->route('objeto.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Objeto  $objeto
     * @return \Illuminate\Http\Response
     */
    public function show(Objeto $objeto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Objeto  $objeto
     * @return \Illuminate\Http\Response
     */
    public function edit(Objeto $objeto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Objeto  $objeto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Objeto $objeto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Objeto  $objeto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Objeto $objeto)
    {
        $borrar = true;
        $objetosEntidad = Rel_objeto_entidad::All();
        foreach($objetosEntidad as $objetoEntidad){
            if ($objetoEntidad->objeto_id == $objeto->id) {
                $borrar = false;
            }
        }
        if ($borrar) {
            $objeto->delete();
            File::delete($objeto->imagen); 
            return "borrado";
        } else {
            return "no";
        }
       
    }
}
