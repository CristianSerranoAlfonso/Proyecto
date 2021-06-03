<?php

namespace App\Http\Controllers;

use App\Models\Enemigo;
use App\Models\Escenario;
use App\Models\Personaje;
use App\Models\Entidad;
use App\Models\Objeto;
use App\Models\Rel_objeto_entidad;
use App\Models\User;
use App\Models\Aventura;
use App\Models\Habilidad;
use App\Models\Rel_entidad_habilidad;
use Illuminate\Http\Request;
use Exception;
use Auth;

class EnemigoController extends Controller
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
    public function crear($id)
    {
        $escenarios = Escenario::All();

        foreach ($escenarios as $escenario) {
            if ($escenario->id == $id) {
                $escenarioElegido = $escenario;
            }
        }
        return view('enemigo.crear', ['escenario' => $escenarioElegido]);
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

        $personajes = Personaje::All();
        $enemigos = Enemigo::All();
        $entidades = Entidad::All();
        $aventuras = Aventura::All();
        $usuarios = User::All();

        if($archivo = $request->file('imagen')) {
            // Creamos la ruta para la imagen en el caso de que sea una imagen lo que se ha subido
            $extension = explode('/', $archivo->getClientMimeType());
            if ($extension[0] != "image") {
                return view("aventura.listar", ['entidades' => $entidades, 'aventuras' => $aventuras, 'personajes' => $personajes, 'users' => $usuarios]);
            }
            $carpeta = "imagenes/enemigo";
            $nombre = $entrada['nombre'].'.'.$extension[1];
            $nombre = str_replace(" ", "", $nombre);
            $nombreBase = $carpeta . '/'.$nombre;
            
            // Almacenamos en un array todos los datos para crear la entidad
            $datosEntidad = ['idUsuario'=>Auth::user()->id, 'nombre'=>$entrada['nombre'], 'sexo'=>$entrada['sexo'], 'deidad'=>$entrada['deidad'], 'vida'=>$entrada['vida'], 'precision'=>$entrada['precision'], 'evasion'=>$entrada['evasion'], 'efectoNegativo1'=>'no', 'baseEfectoNegativo1'=>0,'efectoNegativo2'=>'no', 'baseEfectoNegativo2'=>0,'efectoPositivo1'=>'no','baseEfectoPositivo1'=>0,'efectoPositivo2'=>'no', 'baseEfectoPositivo2'=>0, 'posX'=> 0, 'posY'=>0, 'historia'=>$entrada['historia'], 'imagen'=>$nombreBase];

            // Controlamos que no haya un error 1062 (entrada unique duplicada) mediante el try catch
            try{ 
                $entidad = Entidad::create($datosEntidad);
            }catch(Exception $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return redirect()->route('enemigo.crear', $entrada['escenario']);
                }
            }

            //Almacenamos todos los datos para crear el enemigo
            if ($entrada['tipo'] == 'Jefe') {
                $jefe = 1;
            } else {
                $jefe = 0;
            }
            $enemigo = ['idEntidad'=>$entidad->id, 'jefe'=>$jefe, 'fuerza'=>$entrada['fuerza']];

            //Creamos el enemigo
            $nuevoEnemigo = Enemigo::create($enemigo);
                /* -------------- Añadimos el enemigo al escenario ------------------*/
                $nuevoEnemigo->escenarios()->attach($entrada['escenario']);
            
            //Movemos la imagen a la carpeta
            $archivo->move($carpeta, $nombre);

            //Devolvemos la vista listar con el personaje ya creado
            return redirect()->route('escenario.editar', $entrada['escenario']);
        } else {
            //Si no es una imagen volvemos a la vista listar con mensaje de error
            return redirect()->route('enemigo.crear', $entrada['escenario']);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enemigo  $enemigo
     * @return \Illuminate\Http\Response
     */
    public function show(Enemigo $enemigo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enemigo  $enemigo
     * @return \Illuminate\Http\Response
     */
    public function edit(Enemigo $enemigo)
    {
        $objetosEntidad = Rel_objeto_entidad::All();
        $objetos = Objeto::All();
        $habilidadesEntidad = Rel_entidad_habilidad::All();
        $habilidades = Habilidad::All();
        $contador = 0;
        $objetosEnemigo = [];
        $habilidadesEnemigo = [];

        $enemigo = Enemigo::find($enemigo->id);
        $entidad = Entidad::find($enemigo->idEntidad);
        
        foreach ($objetosEntidad as $objetoEntidad) {
            if ($objetoEntidad->entidad_id == $entidad->id) {
                foreach($objetos as $objeto) {
                    if ($objetoEntidad->objeto_id == $objeto->id) {
                        $objetosEnemigo[$contador] = $objeto;
                        $contador++;
                    }
                }
            }
        }
        $contador = 0;
        foreach ($habilidadesEntidad as $habilidadEntidad) {
            if ($habilidadEntidad->entidad_id == $entidad->id) {
               foreach ($habilidades as $habilidad) {
                   if ($habilidad->id == $habilidadEntidad->habilidad_id) {
                       $habilidadesEnemigo[$contador] = $habilidad;
                       $contador++;
                   }
               }
            }
        }
        return view("entidad.configurar", ["objetosEnemigo"=>$objetosEnemigo, "habilidades"=> $habilidadesEnemigo, "entidad"=>$entidad]);
    }

    public function mostrarObjetos($id) {
        $objetos = Objeto::All();
        $objetosEntidad = Rel_objeto_entidad::All();
        $objetosValidos = [];
        $objetosDentro = [];
        $objetosPosibles = [];
        $contador = 0;
        $contador2 = 0;
        $entidad = Entidad::find($id);


        foreach ($objetos as $objeto) {
            $entra = true;
            foreach ($objetosEntidad as $objetoEntidad) {
                if ($objetoEntidad->entidad_id == $id && $objetoEntidad->objeto_id == $objeto->id) {
                    $entra = false;
                }
            }
            if ($entra) {
                $objetosValidos[$contador] = $objeto;
                $contador++;
            } else {
                $objetosDentro[$contador2] = $objeto;
                $contador2++;
            }
        }

        $contador = 0;
        foreach($objetosValidos as $objetoValido){
            $entra = true;
            foreach($objetosDentro as $objetoDentro){
                if ($objetoValido->tipo == $objetoDentro->tipo) {
                    $entra = false;
                }
            }
            if ($entra) {
                $objetosPosibles[$contador] = $objetoValido;
                $contador++;
            }
        }

        return view("enemigo.objeto", ["objetos"=>$objetosPosibles, "entidad"=>$entidad]);
    }

    public function addObjeto(Request $request, $id) {
        $entrada = $request->all();
        $objetos = Objeto::All();
        $objetosAdd = [];
        $vetoTipoAdd = [];
        $contador = 0;
        $entidad = Entidad::find($id);
    
        foreach($objetos as $objeto) {
            if (isset($entrada["$objeto->id"])) {
                $objetosAdd[$contador] = $objeto;
                $contador++;
            }
        }
        $contador = 0;
        if (count($objetosAdd) <= 3) {
            foreach($objetosAdd as $objeto) {
                $vetoTipoAdd[$contador] = $objeto->tipo;
                $contador++;
            }
            if (count($vetoTipoAdd) != 0) {
                foreach($vetoTipoAdd as $veto) {
                    $contador2 = 0;
                    foreach($objetosAdd as $objeto) {
                        if ($veto == $objeto->tipo) {
                            $contador2++;
                        }
                    }
                    
                    if ($contador2 > 1) {
                        return redirect()->route('entidad.edit', $id);
                    }
                }
            } 
            $entidad->objetos()->attach($objeto->id);
        } 
        return redirect()->route('entidad.edit', $id);
        
        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enemigo  $enemigo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enemigo $enemigo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enemigo  $enemigo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enemigo $enemigo)
    {
        //
    }
}
