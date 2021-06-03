<?php

namespace App\Http\Controllers;

use App\Models\Personaje;
use App\Models\Entidad;
use App\Models\Aventura;
use App\Models\User;
use App\Models\Escenario;
use App\Models\Enemigo;
use Illuminate\Support\Facades\File; 
use App\Models\Rel_enemigo_escenario;
use Illuminate\Http\Request;
use Exception;

class EscenarioController extends Controller
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
    public function crear($id)
    {
        $aventuras = Aventura::All();

        //Se almacena la aventura escogida
        foreach ($aventuras as $aventura) {
            if ($aventura->id == $id) {
                $avElegida = $aventura;
            }
        }

        return view("escenario.crear", ['aventura' => $avElegida]);
    }

    public function guardar(Request $request, $id) {
        $aventuras = Aventura::All();
        $entidades = Entidad::All();
        $personajes = Personaje::All();
        $usuarios = User::All();
        foreach ($aventuras as $av) {
            if ($av->id == $id) {
                $aventura = $av;
            }
        }
        $entrada = $request->all();

        if($archivo = $request->file('imagen')) {
            // Creamos la ruta para la imagen en el caso de que sea una imagen lo que se ha subido
            $extension = explode('/', $archivo->getClientMimeType());
            if ($extension[0] != "image") {
                return view("aventura.listar", ['entidades' => $entidades, 'aventuras' => $aventuras, 'personajes' => $personajes, 'users' => $usuarios]);
            }
            $carpeta = "imagenes/fondo";
            $nombre = $entrada['nombre'].'.'.$extension[1];
            $nombreBase = $carpeta . '/'.$nombre;

            // Almacenamos en un array todos los datos para crear el escenario
            $datosEscenario = ['idAventura'=>$id, 'nombre'=>$entrada['nombre'], 'activo'=>0, 'imagen'=>$nombreBase];

            // Controlamos que no haya un error 1062 (entrada unique duplicada) mediante el try catch
            try{ 
                $escenario = Escenario::create($datosEscenario);
            }catch(Exception $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return view("escenario.crear", ["msj" => "Ya existe un escenario con ese nombre"]);
                }
            }

            //Movemos la imagen a la carpeta
            $archivo->move($carpeta, $nombre);

            //Devolvemos la vista listar con el personaje ya creado
            return view("aventura.listar", ['entidades' => $entidades, 'aventuras' => $aventuras, 'personajes' => $personajes, 'users' => $usuarios]);
        } else {
            //Si no es una imagen volvemos a la vista listar con mensaje de error
            return route("aventura.index");
        }
    }

    public function editar($id) {
        $escenarios = Escenario::All();
        $enemigos = Enemigo::All();
        $entidades = Entidad::All();
        $enemigos_escenario = Rel_Enemigo_Escenario::All();

        foreach ($escenarios as $escenario) {
            if ($escenario->id == $id) {
                $escenarioElegido = $escenario;
            }
        }
        
        //Se almacenan los enemigos relacionados con este escenario
        $contador = 0;
        $enemigosFinales = [];
        foreach ($enemigos as $enemigo) {
            foreach ($enemigos_escenario as $enemigo_escenario) {
                if ($enemigo_escenario->enemigo_id == $enemigo->id && $enemigo_escenario->escenario_id == $id) {
                    $enemigosFinales[$contador] = $enemigo;
                    $contador++;
                }
            }
        }

        //Se almacenan las entidades relacionadas con los enemigos
        $contador = 0;
        $entidadesFinales = [];
        foreach ($entidades as $entidad) {
            foreach ($enemigosFinales as $enemigo) {
                if ($entidad->id == $enemigo->idEntidad) {
                    $entidadesFinales[$contador] = $entidad;
                    $contador++;
                }
                
            }
        }
        return view("escenario.configurar", ['escenario' => $escenarioElegido, 'enemigos' => $enemigosFinales, 'entidades' => $entidadesFinales]);
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
     * @param  \App\Models\Escenario  $escenario
     * @return \Illuminate\Http\Response
     */
    public function show(Escenario $escenario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Escenario  $escenario
     * @return \Illuminate\Http\Response
     */
    public function edit(Escenario $escenario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Escenario  $escenario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Escenario $escenario)
    {
        //
    }

    public function activarEscenario (Request $request, $id) {
        $entrada = $request->all();
        $aventura = Aventura::find($entrada['aventura']);
        $escenarios = Escenario::All();
        foreach($escenarios as $escenario) {
            if ($escenario->idAventura == $entrada['aventura']) {
                if ($escenario->id == $id) {
                    $escenario->fill([
                        'activo' => true
                    ]);
                } else {
                    $escenario->fill([
                        'activo' => false
                    ]);
                }
                $escenario->save();
            }
        }
        return redirect()->route('aventura.edit', $entrada['aventura']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Escenario  $escenario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Escenario $escenario)
    {
        $escenario->delete();
        File::delete($escenario->imagen);
    }
}
