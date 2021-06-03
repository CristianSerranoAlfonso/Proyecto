<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\Enemigo;
use App\Models\Personaje;
use App\Models\Objeto;
use App\Models\Habilidad;
use App\Models\Escenario;
use App\Models\Aventura;
use App\Models\Rel_enemigo_escenario;
use App\Models\Rel_objeto_entidad;
use App\Models\Rel_entidad_habilidad;
use Auth;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

class EntidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entidades = Entidad::All();
        $personajes = Personaje::All();
        $objetos = Objeto::All();
        $objetosentidad = Rel_objeto_entidad::All();
        return view("personaje.listar", ['entidades' =>$entidades, 'personajes' => $personajes, 'objetos' => $objetos, 'objetosentidad' => $objetosentidad]);
    }

    public function mostrarHabilidades($id) {
        $entidad = Entidad::find($id);
        $habilidades = Habilidad::All();
        $habilidadesEntidad = Rel_entidad_habilidad::All();
        $habilidadesEquipadas = [];
        $habilidadesMostrar = [];
        $contador = 0;
        //Almacenamos las que ya tenemos
        foreach ($habilidadesEntidad as $habilidadEntidad) {
            foreach ($habilidades as $habilidad) {
                if ($habilidad->id == $habilidadEntidad->habilidad_id && $habilidadEntidad->entidad_id == $id) {
                    $habilidadesEquipadas[$contador] = $habilidad;
                    $contador++;
                }
            }
        }
        $contador = 0;

        //Almacenamos las habilidades que podrán ser equipadas
        foreach ($habilidades as $habilidad) {
            $entra = TRUE;
            foreach ($habilidadesEquipadas as $hE) {
                if ($habilidad->id == $hE->id) {
                    $entra = FALSE;
                }
            }
            if ($entra) {
                $habilidadesMostrar[$contador] = $habilidad;
                $contador++;
            }
        }
        return view("habilidad.entidad", ['entidad' =>$entidad, 'habilidades' => $habilidadesMostrar]);
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
    public function addHabilidad($id, Request $request) {
        $entidad = Entidad::find($id);
        $enemigos = Enemigo::All();
        $entrada = $request->all();
        $habilidades = Habilidad::All();
        $habilidadesAdd = [];
        $contador = 0;
        foreach($habilidades as $habilidad) {
            if (isset($entrada["$habilidad->id"])) {
                $habilidadesAdd[$contador] = $habilidad;
                $contador++;
                $entidad->habilidades()->attach($habilidad->id);
            }
        }
       
        return redirect()->route('entidad.edit', $id);
        
        
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
     * @param  \App\Models\Entidad  $entidad
     * @return \Illuminate\Http\Response
     */
    public function show(Entidad $entidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entidad  $entidad
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $objetosEntidad = Rel_objeto_entidad::All();
        $enemigos = Enemigo::All();
        $objetos = Objeto::All();
        $habilidadesEntidad = Rel_entidad_habilidad::All();
        $habilidades = Habilidad::All();
        $contador = 0;
        $objetosEnemigo = [];
        $habilidadesEnemigo = [];
        $enemigoEsta = FALSE;

        $entidad = Entidad::find($id);
        foreach ($enemigos as $enemigo) {
            if ($enemigo->idEntidad == $id) {
                $enemigoEsta = TRUE;
            }
        }
        
        foreach ($objetosEntidad as $objetoEntidad) {
            if ($objetoEntidad->entidad_id == $id) {
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
            if ($habilidadEntidad->entidad_id == $id) {
               foreach ($habilidades as $habilidad) {
                   if ($habilidad->id == $habilidadEntidad->habilidad_id) {
                       $habilidadesEnemigo[$contador] = $habilidad;
                       $contador++;
                   }
               }
            }
        }
        if ($enemigoEsta) {
            return view("entidad.configurar", ["objetosEnemigo"=>$objetosEnemigo, "habilidades"=> $habilidadesEnemigo, "entidad"=>$entidad, "tipo" => "enemigo"]);
        }
        return view("entidad.configurar", ["objetosEnemigo"=>$objetosEnemigo, "habilidades"=> $habilidadesEnemigo, "entidad"=>$entidad, "tipo" => "personaje"]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entidad  $entidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entidad $entidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entidad  $entidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entidad $entidad, Request $request)
    {
        $entidad->delete();
        $msj = "Entidad $entidad->nombre ha sido eliminada";
        File::delete($entidad->imagen);
        if ($request->ajax()) {
            return $msj;
        }
    }

    //Cargar imágenes dentro del tablero
    public function mostrarProtagonistaTablero($id) {
        $personajes = Personaje::All();
        $entidades = Entidad::All();
        $personajesIn = [];
        $protagonista=0;
        $contador = 0;
        foreach ($personajes as $personaje) {
            if ($personaje->idAventura == $id) {
                $personajesIn[$contador] = $personaje;
                $contador++;
            }
        }
        foreach ($entidades as $entidad) {
            foreach ($personajesIn as $personaje) {
                if ($entidad->id == $personaje->idEntidad) {
                    if ($entidad->idUsuario == Auth::user()->id) {
                        if ($entidad->vida > 0) {
                            $protagonista = $entidad;
                        }
                    }
                }
            }
        }
        return response()->json($protagonista, 200);

    }

    public function mostarProtagonistaMaster(Request $request) {
        $datos = $request->all();
        $entidad = Entidad::find($datos['prota']);
        return response()->json($entidad, 200);
    }

    public function mostrarHabilidadesMaster(Request $request) {
        $datos = $request->all();
        $entidad = Entidad::find($datos['prota']);
        $habilidades_totales = Rel_entidad_habilidad::All()->where('entidad_id', '=', $datos['prota']);
        $habilidades = Habilidad::All();
        $contador = 0;
        foreach ($habilidades as $habilidad) {
            foreach ($habilidades_totales as $hab_total) {
                if ($hab_total->habilidad_id == $habilidad->id) {
                    $habilidadesProta[$contador] = $habilidad;
                    $contador++;
                }
            }
        }
        return response()->json($habilidadesProta, 200);
    }

    public function mostrarPersonajesTablero($id) {
        $personajes = Personaje::All();
        $entidades = Entidad::All();
        $personajesIn = [];
        $protagonista=0;
        $contador = 0;
        foreach ($personajes as $personaje) {
            if ($personaje->idAventura == $id) {
                $personajesIn[$contador] = $personaje;
                $contador++;
            }
        }
        $contador = 0;
        $personajes = [];
        foreach ($entidades as $entidad) {
            foreach ($personajesIn as $personaje) {
                if ($entidad->id == $personaje->idEntidad) {
                    if ($entidad->idUsuario != Auth::user()->id) {
                        if ($entidad->vida > 0) {
                            $personajes[$contador] = $entidad;
                            $contador++;
                        }
                    }
                }
            }
        }
        return response()->json($personajes, 200);
    }

    public function mostrarEnemigosTablero($id) {
       $enemigos = Enemigo::All();
       $entidades = Entidad::All();
       $ens_escenario = Rel_enemigo_escenario::All();
       $enemigosTablero = [];
       $entidadesTablero = [];
       $contador = 0;
       foreach ($ens_escenario as $en_escenario) {
           foreach ($enemigos as $enemigo) {
               if($en_escenario->escenario_id == $id && $en_escenario->enemigo_id == $enemigo->id) {
                    $enemigosTablero[$contador] = $enemigo;
                    $contador++;
               }
           }
       }
       $contador = 0;
       foreach ($entidades as $entidad) {
           foreach($enemigosTablero as $enemigo) {
                if($entidad->id == $enemigo->idEntidad) {
                    if(!$enemigo->jefe) {
                        if ($entidad->vida > 0) {
                            $entidadesTablero[$contador] = $entidad;
                            $contador++;
                        }
                    }
                    
                }
           }
       }
       return response()->json($entidadesTablero, 200);
    }
    public function mostrarJefesTablero($id) 
    {
        $enemigos = Enemigo::All();
        $entidades = Entidad::All();
        $ens_escenario = Rel_enemigo_escenario::All();
        $enemigosTablero = [];
        $entidadesTablero = [];
        $contador = 0;
        foreach ($ens_escenario as $en_escenario) {
            foreach ($enemigos as $enemigo) {
                if($en_escenario->escenario_id == $id && $en_escenario->enemigo_id == $enemigo->id) {
                     $enemigosTablero[$contador] = $enemigo;
                     $contador++;
                }
            }
        }
        $contador = 0;
        foreach ($entidades as $entidad) {
            foreach($enemigosTablero as $enemigo) {
                 if($entidad->id == $enemigo->idEntidad) {
                     if($enemigo->jefe) {
                         if ($entidad->vida > 0) {
                                $entidadesTablero[$contador] = $entidad;
                                $contador++;
                         }
                     }
                     
                 }
            }
        }
        return response()->json($entidadesTablero, 200);
    }
    public function actualizarEntidades($id) {
        $entidades = Entidad::All();
        $escenarios = Escenario::All();
        $enemigos = Enemigo::All();
        $ens_escenario = Rel_enemigo_escenario::All();
        $personajes = Personaje::All();
        $contador = 0;
        $contador2 = 0;
        foreach ($entidades as $entidad) {
            foreach ($personajes as $personaje) {
                if($entidad->id == $personaje->idEntidad) {
                    if($personaje->idAventura == $id) {
                        $entidadActualizar[$contador] = $entidad;
                        $contador++;
                    }
                }
            }
        }

        foreach ($escenarios as $escenario) {
            if($escenario->idAventura == $id && $escenario->activo) {
                foreach ($ens_escenario as $en_escenario) {
                    if ($en_escenario->escenario_id == $escenario->id) {
                        foreach($enemigos as $enemigo) {
                            if($en_escenario->enemigo_id == $enemigo->id) {
                                $enemigosActualizar[$contador2] = $enemigo;
                                $contador2++;
                            }
                        }
                    }
                    
                }
            }
        }

        foreach ($entidades as $entidad) {
            foreach ($enemigosActualizar as $enemigo) {
                if ($entidad->id == $enemigo->idEntidad) {
                    $entidadActualizar[$contador]= $entidad;
                    $contador++;
                    
                }
            }
        }
        return response()->json($entidadActualizar, 200);
    }
    public function almacenarMovimiento($id, Request $request) 
    {
        $entidad = Entidad::find($id);
        $entidad -> update($request->all());
        return $entidad;
    }
}
