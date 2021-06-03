<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('personaje.index');
})->middleware(['auth']);

Route::resource('aventura',"App\Http\Controllers\AventuraController")->middleware(['auth']);
Route::resource('personaje',"App\Http\Controllers\PersonajeController")->middleware(['auth']);
Route::resource('escenario',"App\Http\Controllers\EscenarioController")->middleware(['auth']);
Route::resource('objeto',"App\Http\Controllers\ObjetoController")->middleware(['auth']);
Route::resource('rel_objeto_entidad',"App\Http\Controllers\RelObjetoEntidadController")->middleware(['auth']);
Route::resource('habilidad',"App\Http\Controllers\HabilidadController")->middleware(['auth']);
Route::get('escenario/create/{id}', "App\Http\Controllers\EscenarioController@crear")->middleware(['auth'])->name('escenario.crear');
Route::post('escenario/save/{id}', "App\Http\Controllers\EscenarioController@guardar")->middleware(['auth'])->name('escenario.guardar');
Route::get('escenario/editar/{id}', "App\Http\Controllers\EscenarioController@editar")->middleware(['auth'])->name('escenario.editar');
Route::post('personaje/all', 'App\Http\Controllers\PersonajeController@all');
Route::resource('entidad',"App\Http\Controllers\EntidadController");
Route::get('aventura/add/{id}', 'App\Http\Controllers\AventuraController@mostrarPj')->middleware(['auth'])->name('aventura.personajes');
Route::patch('aventura/add/{id}', 'App\Http\Controllers\AventuraController@add')->middleware(['auth'])->name('aventura.add');
Route::patch('aventura/delete/{id}', 'App\Http\Controllers\AventuraController@removePj')->middleware(['auth'])->name('aventura.remove');
Route::resource('enemigo',"App\Http\Controllers\EnemigoController")->middleware(['auth']);
Route::get('enemigo/create/{id}', "App\Http\Controllers\EnemigoController@crear")->middleware(['auth'])->name('enemigo.crear');
Route::delete('obj/entidad/{id}',"App\Http\Controllers\RelObjetoEntidadController@borrar")->name('eliminar_objEntidad')->middleware(['auth']);
Route::delete('habilidad/entidad/{id}',"App\Http\Controllers\RelEntidadHabilidadController@borrar")->name('eliminar_habEntidad')->middleware(['auth']);
Route::get('enemigo/objeto/{id}', "App\Http\Controllers\EnemigoController@mostrarObjetos")->middleware(['auth'])->name('enemigo.objeto');
Route::get('entidad/habilidad/{id}', "App\Http\Controllers\EntidadController@mostrarHabilidades")->middleware(['auth'])->name('entidad.habilidad');
Route::patch('enemigo/addobjeto/{id}', "App\Http\Controllers\EnemigoController@addobjeto")->middleware(['auth'])->name('enemigo.addobjeto');
Route::patch('entidad/addhabilidad/{id}', "App\Http\Controllers\EntidadController@addHabilidad")->middleware(['auth'])->name('entidad.addHabilidad');
Route::patch('aventura/activar/{id}', "App\Http\Controllers\EscenarioController@activarEscenario")->middleware(['auth'])->name('escenario.activar');

//TABLERO
    //Entrar tablero
    Route::get('aventura/tablero/master/{id}', 'App\Http\Controllers\AventuraController@tableroMaster')->middleware(['auth']);
    Route::get('aventura/tablero/{id}', 'App\Http\Controllers\AventuraController@tablero')->middleware(['auth']);

    //Mostrar tablero
    Route::get('aventura/tablero/mostrar/{id}', 'App\Http\Controllers\EntidadController@mostrarProtagonistaTablero')->middleware(['auth'])->name('entidad.cargarProta');
    Route::get('aventura/tablero/mostrarPj/{id}', 'App\Http\Controllers\EntidadController@mostrarPersonajesTablero')->middleware(['auth'])->name('entidad.cargarPersonajes');
    Route::get('aventura/tablero/actualizar/{id}', 'App\Http\Controllers\EntidadController@actualizarEntidades')->middleware(['auth'])->name('entidad.cargarEntidades');
    Route::get('aventura/tablero/mostrarEnemigo/{id}', 'App\Http\Controllers\EntidadController@mostrarEnemigosTablero')->middleware(['auth'])->name('entidad.cargarEnemigos');
    Route::get('aventura/tablero/mostrarJefe/{id}', 'App\Http\Controllers\EntidadController@mostrarJefesTablero')->middleware(['auth'])->name('entidad.cargarJefes');
    Route::get('aventura/tablero/actualizarPj/{id}', 'App\Http\Controllers\EntidadController@actualizarPersonajesTablero')->middleware(['auth'])->name('entidad.actualizarPersonajes');
    Route::patch('aventura/tablero/mov/{id}', 'App\Http\Controllers\EntidadController@almacenarMovimiento')->middleware(['auth'])->name('entidad.almacenarMovimiento');
    Route::post('prota', 'App\Http\Controllers\EntidadController@mostarProtagonistaMaster')->middleware(['auth'])->name('mostrar.prota');
    Route::post('protaHabilidades', 'App\Http\Controllers\EntidadController@mostrarHabilidadesMaster')->middleware(['auth'])->name('mostrar.habilidades');

    //Foco
    Route::get('aventura/tablero/foco/{id}', 'App\Http\Controllers\AventuraController@cargarFoco')->middleware(['auth'])->name('aventura.cargarFoco');

    //Tiradas
    Route::get('aventura/tirada/{id}', 'App\Http\Controllers\AventuraController@cargarTiradas')->middleware(['auth'])->name('aventura.cargarTiradas');

    //Lanzar habilidad
    Route::get('aventura/tablero/habilidad/{id}', 'App\Http\Controllers\AventuraController@lanzarHabilidad')->middleware(['auth'])->name('aventura.lanzarHabilidad');
    Route::get('tirada/{id}', 'App\Http\Controllers\TiradaController@addTirada')->middleware(['auth'])->name('tirada.addTirada');


require __DIR__.'/auth.php';
