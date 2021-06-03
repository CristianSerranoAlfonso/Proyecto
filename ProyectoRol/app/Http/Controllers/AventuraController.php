<?php

namespace App\Http\Controllers;

use App\Models\Personaje;
use App\Models\Entidad;
use App\Models\Aventura;
use App\Models\User;
use App\Models\Objeto;
use App\Models\Escenario;
use App\Models\Enemigo;
use App\Models\Tirada;
use App\Models\Habilidad;
use App\Models\Rel_enemigo_escenario;
use App\Models\Rel_entidad_habilidad;
use App\Models\Rel_objeto_entidad;
use Auth;
use Exception;
use Illuminate\Http\Request;


class AventuraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($msj = "")
    { 
        $entidades = Entidad::All();
        $usuarios = User::All();
        $personajes = Personaje::All();
        $aventuras = Aventura::All();
        if ($msj != "") {
            return view("aventura.listar", ['entidades' => $entidades, 'aventuras' => $aventuras, 'personajes' => $personajes, 'users' => $usuarios, 'msj'=>$msj]);
        } else {
            return view("aventura.listar", ['entidades' => $entidades, 'aventuras' => $aventuras, 'personajes' => $personajes, 'users' => $usuarios]);
        }
        


    }
    /* 
        Devuelve la vista de tablero ligada a la aventura únicamente si eres el master o uno de tus pj están dentro de la aventura
     */
    public function tablero($id)
    {
        $tiradas = Tirada::All();
        $entidades = Entidad::All();
        $usuarios = User::All();
        $personajes = Personaje::All();
        $aventura = Aventura::find($id);
        $escenarios = Escenario::All();
        $habilidades = Habilidad::All();
        $habilidadesEntidad = Rel_entidad_habilidad::All();
        $contador = 0;
        //Seleccionamos personajes en la aventura
        foreach ($personajes as $personaje) {
            if($personaje->idAventura == $id) {
                $personajesSeleccionados[$contador] = $personaje;
                $contador++;
            }
        }

        //Seleccionamos entidades en la partida
        foreach ($entidades as $entidad) {
            foreach ($personajesSeleccionados as $pj) {
                if ($entidad->id == $pj->idEntidad) {
                    if ($entidad->idUsuario == Auth::user()->id) {
                        $protagonistaEntidad = $entidad;
                        $protagonistaPj = $pj;
                    }
                }
            }
        }
        //Seleccionamos el escenario actual
        foreach ($escenarios as $escenario) {
            if ($escenario->idAventura == $id) {
                if ($escenario->activo) {
                    $escenarioActivo = $escenario;
                }
            }
        }
        $habilidadesProta = [];
        $contador = 0;
        foreach($habilidades as $habilidad) {
            foreach($habilidadesEntidad as $habilidadEntidad) {
                if ($habilidadEntidad->habilidad_id == $habilidad->id && $habilidadEntidad->entidad_id == $protagonistaEntidad->id) {
                    if ($habilidad->nivelHabilidad <= $protagonistaPj->nivel) {
                        $habilidadesProta[$contador] = $habilidad;
                        $contador++;
                    }
                }
            }
        }
        
        //Almacenamos las tiradas
        $contador = 0;
        foreach ($tiradas as $tirada) {
            if ($tirada->idEscenario == $escenarioActivo->id) {
                $nombreLanza = Entidad::find($tirada->idEntidad)->nombre;
                $habilidad = Habilidad::find($tirada->idHabilidad)->nombre;
                $tiradaEscenario[$contador] = "$nombreLanza ha lanzado la habilidad $habilidad a $tirada->foco y el valor de su tirada ha sido $tirada->tirada.";
                $contador++;
            }
        }
        
        if (!isset($protagonistaEntidad)) {
            return redirect()->route('aventura.index');
        } else {
            return view('tablero.tablero', ["id"=>$id, "tiradas"=>$tiradaEscenario, "entidad" => $protagonistaEntidad, "habilidades"=>$habilidadesProta, "escenario" =>$escenarioActivo, "users" => $usuarios, "personaje" => $protagonistaPj, "aventura" => $aventura]);         
        }
        return redirect()->route('aventura.index');
    }
    
    public function tableroMaster($id)
    {
        $entidades = Entidad::All();
        $usuarios = User::All();
        $tiradas = Tirada::All();
        $personajes = Personaje::All();
        $aventura = Aventura::find($id);
        $escenarios = Escenario::All();
        $contador = 0;
        //Seleccionamos personajes en la aventura
        foreach ($personajes as $personaje) {
            if($personaje->idAventura == $id) {
                $personajesSeleccionados[$contador] = $personaje;
                $contador++;
            }
        }

        //Seleccionamos el escenario actual
        foreach ($escenarios as $escenario) {
            if ($escenario->idAventura == $id) {
                if ($escenario->activo) {
                    $escenarioActivo = $escenario;
                }
            }
        }
        $contador = 0;
        foreach ($tiradas as $tirada) {
            if ($tirada->idEscenario == $escenarioActivo->id) {
                $nombreLanza = Entidad::find($tirada->idEntidad)->nombre;
                $habilidad = Habilidad::find($tirada->idHabilidad)->nombre;
                $tiradaEscenario[$contador] = "$nombreLanza ha lanzado la habilidad $habilidad a $tirada->foco y el valor de su tirada ha sido $tirada->tirada.";
                $contador++;
            }
        }
        if (empty($personajesSeleccionados)) {
            return redirect()->route('aventura.index');
        } else {
            if ($aventura->idUsuario == Auth::user()->id) {
                return view('tablero.master', ["id"=>$id, "tiradas"=>$tiradaEscenario, "entidades" => $entidades, "escenario" =>$escenarioActivo, "users" => $usuarios, "personajes" => $personajesSeleccionados, "aventura" => $aventura]);
            }
            foreach ($entidades as $entidad) {
                if ($entidad->idUsuario == Auth::user()->id) {
                    foreach ($personajesSeleccionados as $personaje) {
                        if ($personaje->idEntidad == $entidad->id) {
                            return view('tablero.master', ["id"=>$id, "tiradas"=>$tiradaEscenario, "entidades" => $entidades, "escenario" =>$escenarioActivo, "users" => $usuarios, "personajes" => $personajesSeleccionados, "aventura" => $aventura]);
                        }
                    }
                }
            }
            return redirect()->route('aventura.index');
        }
    }
    
    public function cargarFoco($id, Request $request)
    {
        $datos = $request->all();
        $habilidad = Habilidad::find($datos['id']);
        $entidad = Entidad::find($datos['idEntidad']);
        $entidades = Entidad::All();
        $enemigos = Enemigo::All();
        $enemigosEscenario = Rel_enemigo_escenario::All();
        $escenario = Escenario::find($id);
        $contador = 0;

        //Sacamos la aventura
        $aventuraActual = Aventura::All()->where('id', '=', $escenario->idAventura);

        //Conseguimos los personajes de la aventura
        $pjsAventura = Personaje::All()->where('idAventura', '=', $aventuraActual[1]->id);

        //Comprobamos si es un enemigo o un personaje ----------------------------------
        $enemigoSeleccionado = Enemigo::All()->where('idEntidad', '=', $entidad->id);

        //Comprobamos qué tipo es el prota ---------------------------------------------
        
        $protaEnemigo = Enemigo::All()->where('idEntidad', '=', $datos['prota']);

        
        $protaEsPj = FALSE;
        $seleccionadoEsPj = FALSE;
        if (count($protaEnemigo) == 0) {
            $protaEsPj = TRUE;
        }

        if(count($enemigoSeleccionado) == 0) {
            $seleccionadoEsPj = TRUE;
        }
        //------------------------------------------------------------------------------

        if ($habilidad->ataque) {
            if (($protaEsPj && $seleccionadoEsPj) || (!$protaEsPj && !$seleccionadoEsPj)) {
                $msj = "No puedes pegar a tus aliados";
                return response()->json($msj, 200);
            } 
            if($habilidad->area) {
                if ($protaEsPj) {
                    foreach($entidades as $e) {
                        foreach ($enemigos as $enemigo) {
                            if($enemigo->idEntidad == $e->id) {
                                foreach($enemigosEscenario as $enemigoEscenario) {
                                    if($enemigoEscenario->enemigo_id == $enemigo->id && $enemigoEscenario->escenario_id == $id){
                                        if ($e->posX >= ($entidad->posX - 80) && $e->posX <= ($entidad->posX + 80)) {
                                            if ($e->posY >= ($entidad->posY - 80) && $e->posY <= ($entidad->posY + 80)) {
                                                if($e->vida > 0) {
                                                    $entidadFoco[$contador] = $e;
                                                    $contador++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }  
                    }
                } else {
                    foreach($entidades as $e) {
                        foreach ($pjsAventura as $pj) {
                            if ($pj->idEntidad == $e->id) {
                                if ($e->posX >= ($entidad->posX - 80) && $e->posX <= ($entidad->posX + 80)) {
                                    if ($e->posY >= ($entidad->posY - 80) && $e->posY <= ($entidad->posY + 80)) {
                                        if($e->vida > 0) {
                                            $entidadFoco[$contador] = $e;
                                            $contador++;
                                        }
                                    }
                                }
                            }
                            
                        }  
                    }
                }
                return response()->json($entidadFoco, 200); 
            }
        } else {
            if (($protaEsPj && !$seleccionadoEsPj) || (!$protaEsPj && $seleccionadoEsPj)) {
                $msj = "No puedes curar a tus enemigos";
                return response()->json($msj, 200);
            } 
            if($habilidad->area) {
                if ($protaEsPj) {
                    foreach($entidades as $e) {
                        foreach ($pjsAventura as $personaje) {
                            if($personaje->idEntidad == $e->id) {
                                    $entidadFoco[$contador] = $e;
                                    $contador++;
                            }
                        }  
                    }
                } else {
                    foreach($entidades as $e) {
                        foreach ($enemigos as $enemigo) {
                            if($enemigo->idEntidad == $e->id) {
                                foreach($enemigosEscenario as $enemigoEscenario) {
                                    if($enemigoEscenario->enemigo_id == $enemigo->id && $enemigoEscenario->escenario_id == $id){
                                        if ($e->posX >= ($entidad->posX - 80) && $e->posX <= ($entidad->posX + 80)) {
                                            if ($e->posY >= ($entidad->posY - 80) && $e->posY <= ($entidad->posY + 80)) {
                                                if($e->vida > 0) {
                                                    $entidadFoco[$contador] = $e;
                                                    $contador++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }  
                    }
                }
                return response()->json($entidadFoco, 200);
            }
        }
        return response()->json($entidad, 200);
    }

    public function lanzarHabilidad($id, Request $request)
    {
        $datos = $request->all();
        $habilidad = Habilidad::find($datos['habilidad']);
        $objetos = Objeto::All();
        $objetosEntidad = Rel_objeto_entidad::All();
        $aventura = Aventura::find($id);
        $entidades = Entidad::All();
        $personajes = Personaje::All();
        $contador = 0;
        $entidadesFoco = [];
        $dmgHabilidad = 0;
        $enemigo = false;
        $objetosEntidadLanzaHabilidad = [];

        //Entidades foco
        foreach ($entidades as $entidad) {
            foreach ($datos['idEntidades'] as $idE) {
                if ($idE == $entidad->id) {
                    $entidadesFoco[$contador] = $entidad;
                    $contador++;
                }
            }
        }
        //Entidad que lanza la habilidad
        $entidadLanzaHabilidad = Entidad::find($datos['prota']);
           
            //Objetos entidad lanza la habilidad
            $contador = 0;
            foreach ($objetos as $objeto) {
                foreach ($objetosEntidad as $objetoEntidad) {
                    if ($objetoEntidad->entidad_id == $entidadLanzaHabilidad->id && $objetoEntidad->objeto_id == $objeto->id) {
                        $objetosEntidadLanzaHabilidad[$contador] = $objeto;
                        $contador++;
                    }
                }
            }

            //Personaje/Enemigo que lanza la habilidad
            $enemigoLanza = FALSE;
            $personajesLanzaHabilidad = Personaje::All()->where('idEntidad', '=', $entidadLanzaHabilidad->id);
            if (count($personajesLanzaHabilidad) == 0) {
                $enemigosLanzaHabilidad = Enemigo::All()->where('idEntidad', '=', $entidadLanzaHabilidad->id);
                $enemigoLanza = TRUE;
                foreach ($enemigosLanzaHabilidad as $enemigo) {
                    $enemigoLanzaHabilidad = $enemigo;
                }
            }
            foreach ($personajesLanzaHabilidad as $personaje) {
                $personajeLanzaHabilidad = $personaje;
            }
            
            //Buscamos el escalado de la habilidad
            $escaladoHabilidad = $habilidad->facultadPositiva;
            $escaladoHabilidad = strtolower($escaladoHabilidad);
            
            //Vemos si es ataque o cura
            if ($habilidad->ataque) {

                //Calculamos el daño base de la habilidad
                if ($enemigoLanza) {
                    $dmgHabilidad = $dmgHabilidad + $habilidad->valorBase;
                    $dmgHabilidad = $dmgHabilidad + $enemigoLanzaHabilidad->fuerza;

                } else {
                    $dmgHabilidad = $dmgHabilidad + $personajeLanzaHabilidad->$escaladoHabilidad;
                    $dmgHabilidad = $dmgHabilidad + $habilidad->valorBase;
                }
                foreach($objetosEntidadLanzaHabilidad as $objetoEnt){
                    $dmgHabilidad = $dmgHabilidad + $objetoEnt->$escaladoHabilidad;
                }

                //Quitamos vida al foco
                foreach ($entidadesFoco as $entidadFoco) {
                    $vidaFoco = $entidadFoco->vida;
                    $vidaActual = $vidaFoco - $dmgHabilidad;
                    $entidadFoco->fill([
                        'vida' => $vidaActual
                    ]);
                    $entidadFoco->save();
                }
            } else {
                //Calculamos la cura de la habilidad
                $cura = 0;
                if ($enemigoLanza) {
                    $cura = $cura + $habilidad->valorBase;
                    $cura = $cura + $enemigoLanzaHabilidad->fuerza;

                } else {
                    $cura = $cura + $personajeLanzaHabilidad->$escaladoHabilidad;
                    $cura = $cura + $habilidad->valorBase;
                }
                foreach($objetosEntidadLanzaHabilidad as $objetoEnt){
                    $cura = $cura + $objetoEnt->$escaladoHabilidad;
                }

                foreach ($entidadesFoco as $entidadFoco) {
                    $vidaActual = $entidadFoco->vida;
                    if($vidaActual < 20) {
                        $vidaActual = $vidaActual + $cura;
                        if($vidaActual > 20) {
                            $vidaActual = 20;
                        } 
                    }
                    $entidadFoco->fill([
                        'vida' => $vidaActual
                    ]);
                    $entidadFoco->save();
                }
            }
            return true;
        
        
    }

    public function cargarTiradas($id) {
        $tiradas = Tirada::All()->where('idEscenario', '=', $id);
        $contador = 0;
        foreach ($tiradas as $tirada) {
            $nombresEntidad = Entidad::All()->where('id', '=', $tirada->idEntidad);
            foreach ($nombresEntidad as $nombre) {
                $nombreEntidad = $nombre->nombre;
            }
            $habilidades = Habilidad::All()->where('id', '=', $tirada->idHabilidad);
            foreach ($habilidades as $hab) {
                $habilidad = $hab->nombre;
            }
            $tiradaEscenario[$contador] = "$nombreEntidad ha lanzado la habilidad $habilidad a $tirada->foco y el valor de su tirada ha sido $tirada->tirada.";
            $contador++;
        }
        return response()->json($tiradaEscenario, 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('aventura.crear');
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
        $entidades = Entidad::All();
        $usuarios = User::All();
        $personajes = Personaje::All();
        $aventuras = Aventura::All();

        $datosEntidad = ['idUsuario'=>$entrada['us'],'nombre'=>$entrada['nombre']];
        try{ 
            $aventura = Aventura::create($datosEntidad);
        }catch(Exception $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return view("aventura.listar", ['entidades' => $entidades, 'aventuras' => $aventuras, 'personajes' => $personajes, 'users' => $usuarios, "msj" => "Ya existe una aventura con ese nombre"]);            
            }
        }
        return redirect()->route('aventura.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aventura $aventura
     * @return \Illuminate\Http\Response
     */
    public function show(Aventura $aventura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aventura  $aventura
     * @return \Illuminate\Http\Response
     */
    public function edit(Aventura $aventura)
    {
        $escenarios= Escenario::All();
        $entidades = Entidad::All();
        $personajes = Personaje::All();
        $aventuras = Aventura::All();
        $contador = 0;
        $escenariosAventura = [];
        foreach ($escenarios as $escenario) {
            if ($escenario->idAventura == $aventura->id) {
                $escenariosAventura[$contador] = $escenario;
                $contador++;
            }
        }
        $contador = 0;
        $entidadesAventura = [];
        foreach ($personajes as $personaje) {
            if ($personaje->idAventura == $aventura->id) {
                foreach ($entidades as $entidad) {
                    if($personaje->idEntidad == $entidad->id) {
                        $entidadesAventura[$contador] = $entidad;
                        $contador++;
                    }
                }
            }
        }
        if ($aventura->idUsuario == Auth::user()->id) {
            return view("aventura.editar", ["aventura"=>$aventura, "escenarios"=>$escenariosAventura, "personajes"=>$entidadesAventura]); 
        } else {
            return redirect()->route('aventura.index');
        }
         
    }
    /* 
        Muestra todos los posibles personajes que se podrían unir a la aventura
     */
    public function mostrarPj($id) 
    {
        $aventuras = Aventura::All();
        $personajes = Personaje::All();
        $entidades = Entidad::All();
        $usuarios = User::All();
        $personajesValidos = [];
        $personajesAdd = [];
        $entidadesAdd = [];
        $usuariosAdd = [];
        $aventuraElegida;
        //Aventura elegida
        foreach($aventuras as $aventura) {
            if ($aventura->id == $id) {
                $aventuraElegida = $aventura;
            }
        }
        //Almacenar usuarios vetados porque ya existe un pj suyo en la aventura
        $contador = 0;
        $vetados = [];
        foreach($entidades as $entidad) {
            foreach($personajes as $personaje) {
                if ($entidad->id == $personaje->idEntidad) {
                    if ($personaje->idAventura == $aventuraElegida->id) {
                        $vetados[$contador] = $entidad->idUsuario;
                        $contador++;
                    }
                }
            }
        }
        // Almacenar personajes que pueden entrar sin ser el del propio master ni de los usuarios que ya tengan otro pj
        $contador = 0;
            foreach($entidades as $entidad) {
                foreach($personajes as $personaje) {
                    $entra = TRUE;
                    if($personaje->idEntidad == $entidad->id){
                        if($entidad->idUsuario != Auth::user()->id) {
                            if(empty($vetados)) {
                                $personajesValidos[$contador] = $personaje;
                                $contador++;
                                $entra = FALSE;
                            } else {
                                foreach($vetados as $usuario) {
                                    if($usuario == $entidad->idUsuario) {
                                        $entra = FALSE;
                                        break;
                                    }
                                }
                            }
                        } else {
                            $entra = FALSE;
                            break;
                        }
                    } else {
                        $entra = FALSE;
                    }
                    if ($entra) {
                        $personajesValidos[$contador] = $personaje;
                        $contador++;
                    }
                }
            }
        //Personajes que pueden entrar en la aventura
        $contador = 0;
        foreach ($personajesValidos as $personaje) {
            if ($personaje->idAventura == NULL) {
                $personajesAdd[$contador] = $personaje;
                $contador++;
            } 
        }

        //Entidades que pueden entrar en la aventura
        $contador = 0;
        $contador2 = 0;
        foreach ($entidades as $entidad) {
            $contadorPrueba = $contador;
            foreach($personajesAdd as $personaje){
                if($personaje->idEntidad == $entidad->id){
                    $entidadesAdd[$contador] = $entidad;
                    $contador++;
                }
            }
        }

        //Usuarios que pueden entrar en la aventura
        $contador = 0;
        foreach($usuarios as $usuario) {
            foreach($entidadesAdd as $entidad){
                if($entidad->idUsuario == $usuario->id){
                    $usuariosAdd[$contador] = $usuario;
                    $contador++;
                }
            }
        }
        return view("aventura.addPj", ["aventura"=>$aventuraElegida, "personajes"=>$personajesAdd, "entidades" => $entidadesAdd, "usuarios" => $usuariosAdd]); 
    }
    /* 
        Añade los diferentes personajes seleccionados en la tabla dentro de la aventura (si hay más de un personaje del mismo usuario devolverá la
        pantalla de aventuras)    
    */
    public function add(Request $request, $id)
    {
        $personajes = Personaje::All();
        $entidades = Entidad::All();
        $entrada = $request->all();
        $veto = [];
        $personajesMandados = [];
        $entidadesMandadas = [];
        $contador = 0;
        // Almacenar los usuarios
        foreach ($entidades as $entidad) {
            foreach ($personajes as $personaje) {
                if ($entidad->id == $personaje->idEntidad) {
                    if (isset($entrada["$personaje->id"])) {
                        $veto[$contador] = $entidad->idUsuario;
                        $personajesMandados[$contador] = $personaje;
                        $entidadesMandadas[$contador] = $entidad;
                        $contador++;
                    }
                }
                
            }
        }
        
        foreach($entidadesMandadas as $entidad) {
            $contador = 0;
            foreach ($personajesMandados as $personaje) {
                if ($entidad->id == $personaje->idEntidad) {
                    foreach($veto as $usuario) {
                        if ($entidad->idUsuario == $usuario) {
                           $contador++;
                        }
                    }
                    if ($contador > 1) {
                        return redirect()->route('aventura.index');
                    }
                }
            }
        }
        
        foreach ($personajesMandados as $personaje) {
            $personaje->fill([
                    'idAventura' => $id
                ]);

                $personaje->save();
        }
        return redirect()->route('aventura.index');
    }
    /*
        Borra el personaje de la aventura en la que está, dejando el valor idAventura en NULL 
     */
    public function removePj(Request $request, $id)
    {
        $personajes = Personaje::All();
        $entidades = Entidad::All();
        $msj = "se ha eliminado" . $id;
        foreach ($entidades as $entidad) {
            foreach ($personajes as $personaje) {
                if ($entidad->id == $personaje->idEntidad) {
                    if ($entidad->id == $id) {
                        $personaje->fill([
                            'idAventura' => NULL
                        ]);
                        $personaje->save();
                        $msj = "se ha eliminado" . $id . "y ha entrado y borrado";
                    }
                }
            }
        }
        
       
        if ($request->ajax()) {
            return $msj;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aventura  $aventura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aventura $aventura)
    {
        $aventura->fill($request->input())->saveOrFail();
        $aventuras = Aventura::All();
        return view("aventura.listar", ["aventuras" => $aventuras, "msj" => "Imagen $aventuras->nombre ha sido modificada"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aventura  $aventura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aventura $aventura, Request $request)
    {
        $aventura->delete();
        $message = "Aventura $aventura->nombre ha sido borrada";
        if($request->ajax()){
            return $message;
        }
    }
}
