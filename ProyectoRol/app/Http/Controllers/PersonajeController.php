<?php

namespace App\Http\Controllers;

use App\Models\Personaje;
use App\Models\Entidad;
use App\Models\Rel_objeto_entidad;
use App\Models\Objeto;
use App\Models\User;
use App\Models\Aventura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\DB;
use Exception;

class PersonajeController extends Controller
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
        $usuarios = User::All();
        $aventuras = Aventura::All();
        return view("personaje.listar", ['entidades' =>$entidades, 'personajes' => $personajes, 'objetos' => $objetos, 'objetosentidad' => $objetosentidad, 'users'=>$usuarios, 'aventuras'=>$aventuras]);
    }
    public function all(Request $request)
    {
        $entidades = Entidad::All();
        $personajes = Personaje::All();
        $objetos = Objeto::All();
        $objetosentidad = Rel_objeto_entidad::All();
        $usuarios = User::All();
        if ($request->ajax()) {
            $data = array(
                'entidades' => $entidades,
                'personajes' => $personajes,
                'objetos' => $objetos,
                'objetosentidad' => $objetosentidad,
                'usuarios' => $usuarios
            );

            return response(json_encode($data), 200)->header('Content-type', 'text/plain');
        } 
        

        return response(json_encode($entidades), 200)->header('Content-type','text/plain');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('personaje.crear');
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
        $entidades = Entidad::All();
        $objetos = Objeto::All();
        $usuarios = User::All();
        $aventuras = Aventura::All();
        $objetosentidad = Rel_objeto_entidad::All();
        
        if($archivo = $request->file('imagen')) {
            // Creamos la ruta para la imagen en el caso de que sea una imagen lo que se ha subido
            $extension = explode('/', $archivo->getClientMimeType());
            if ($extension[0] != "image") {
                return view("personaje.listar", ["personajes"=>$personajes, "objetos"=>$objetos, "entidades"=>$entidades, "objetosentidad"=>$objetosentidad, 'aventuras'=>$aventuras, "msj" => "No se ha subido ninguna imagen"]);
            }
            $carpeta = "imagenes/personaje";
            $nombre = $entrada['nombre'].'.'.$extension[1];
            $nombre = str_replace(" ", "", $nombre);
            $nombreBase = $carpeta . '/'.$nombre;

            // Almacenamos en un array todos los datos para crear la entidad
            $datosEntidad = ['idUsuario'=>$entrada['us'], 'nombre'=>$entrada['nombre'], 'sexo'=>$entrada['sexo'], 'deidad'=>$entrada['deidad'], 'vida'=>20, 'precision'=>100, 'evasion'=>0, 'efectoNegativo1'=>'no', 'baseEfectoNegativo1'=>0,'efectoNegativo2'=>'no', 'baseEfectoNegativo2'=>0,'efectoPositivo1'=>'no','baseEfectoPositivo1'=>0,'efectoPositivo2'=>'no', 'baseEfectoPositivo2'=>0, 'posX'=> 0, 'posY'=>0, 'historia'=>$entrada['historia'], 'imagen'=>$nombreBase];

            // Controlamos que no haya un error 1062 (entrada unique duplicada) mediante el try catch
            try{ 
                $entidad = Entidad::create($datosEntidad);
            }catch(Exception $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return view("personaje.crear", ["msj" => "Ya existe un personaje con ese nombre"]);
                }
            }

            //Almacenamos todos los datos para crear el personaje
            $personaje = ['idEntidad'=>$entidad->id, 'idAventura'=>NULL, 'nivel'=>1, 'turno'=>0, 'armadura'=>0, 'fuerza'=>2, 'destreza'=>2, 'inteligencia'=>2,'cordura'=>2,'carisma'=>2,'sabiduria'=>2, 'caracteristica1'=>'no', 'caracteristica2'=>'no', 'caracteristica3'=>'no', 'dinero'=>10];

            //Creamos el personaje
            Personaje::create($personaje);
                /* -------------- OBJETOS ------------------*/
                    /*------------ ARMA-------------*/
                $entidad = Entidad::find($entidad->id);
                $entidad->objetos()->attach(13);
                    /*---------- ARMADURA-------------*/
                $entidad = Entidad::find($entidad->id);
                $entidad->objetos()->attach(23);
                    /*---------- ABALORIO-------------*/
                $entidad = Entidad::find($entidad->id);
                $entidad->objetos()->attach(15);
            
            //Movemos la imagen a la carpeta
            $archivo->move($carpeta, $nombre);

            //Devolvemos la vista listar con el personaje ya creado
            return redirect()->route('personaje.index');
        } else {
            //Si no es una imagen volvemos a la vista listar con mensaje de error
            return view("personaje.listar", ["personajes"=>$personajes, "objetos"=>$objetos, "entidades"=>$entidades, "objetosentidad"=>$objetosentidad, 'aventuras'=>$aventuras, "msj" => "Debes subir una imagen para completar la creación"]);
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Personaje  $personaje
     * @return \Illuminate\Http\Response
     */
    public function show(Personaje $personaje)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Personaje  $personaje
     * @return \Illuminate\Http\Response
     */
    public function edit(Entidad $personaje)
    {
        return view('personaje.editar', ["personaje" => $personaje]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Personaje  $personaje
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entidad $personaje)
    {
        
        if($archivo = $request->file('imagen')) {
            $extension = explode('/', $archivo->getClientMimeType());
            if ($extension[0] != "image") {
                return view("personaje.editar", ["msj" => "No se ha subido ninguna imagen"]);
            }
            $carpeta = "imagenes/personaje";
            $nombre = $personaje->nombre.'.'.$extension[1];
            $archivo->move($carpeta, $nombre);
        }
        
        $entidades = Entidad::All();
        $personajes = Personaje::All();
        $objetos = Objeto::All();
        $usuarios = User::All();
        $aventuras = Aventura::All();
        $objetosentidad = Rel_objeto_entidad::All();
        return view("personaje.listar", ['entidades' =>$entidades, 'aventuras' => $aventuras, 'personajes' => $personajes, 'objetos' => $objetos, 'users'=>$usuarios, 'objetosentidad' => $objetosentidad]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Personaje  $personaje
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personaje $personaje, Request $request)
    {
       //
    }
}
