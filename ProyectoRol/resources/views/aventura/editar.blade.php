<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
        {{ __('Configuración de aventura: ') }} {{$aventura->nombre}}
        </h2>
    </x-slot>
    @push('head')
        <script>
            $(document).ready(function (){
                $('.btn-delete').click(function(e){

                    e.preventDefault();

                    var row = $(this).parents('tr');
                    var id = row.data('id');
                    var form = $('#form-delete');
                    var url = form.attr('action').replace(':USER_ID', id);
                    var data = form.serialize();
                    row.fadeOut();
                    
                    $.post(url, data, function (result){
                        alert(result);
                    }); 
                });

                $('.btn-delete-escenario').click(function(e){

                    e.preventDefault();

                    var row = $(this).parents('tr');
                    var id = row.data('id');
                    var form = $('#form-delete-escenario');
                    var url = form.attr('action').replace(':USER_ID', id);
                    var data = form.serialize();
                    row.fadeOut();

                    $.post(url, data, function (result){
                        alert(result);
                    }); 
                });
            });
        </script>
    @endpush
    <div>
        {{$msj ?? ''}}
    </div>
    <div class="text-primary mt-6 flex">
        <div class="m-auto w-5/6 h-4/5">
        <div class="container mx-auto px-4 sm:px-8">
            <div class="py-8">
                <h2 class="text-2xl font-semibold leading-tight">Tabla de Escenarios</h2>
                @if($escenarios != NULL)
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-hidden">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal w-full">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Escenario</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Estado</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($escenarios as $escenario)
                                        <tr data-id="{{ $escenario->id }}" class="bg-primary2 lg:hover:bg-secundary1 md:hover:bg-secundary1 flex lg:table-row md:table-row flex-row lg:flex-row md:flex-row flex-wrap lg:flex-no-wrap md:flex-no-wrap mb-10 lg:mb-0">
                                            <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Escenario</span>
                                                <p class="text-primary whitespace-no-wrap">
                                                    {{$escenario->nombre}}
                                                </p>
                                            </td>
                                            @if($escenario->activo)
                                                <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                    <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Estado</span>
                                                    <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                        <span class="relative">Activado</span>
                                                    </span>
                                                </td>
                                            @else
                                                <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                    <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Estado</span>
                                                    <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                        <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                        <span class="relative">Desactivado</span>
                                                    </span>
                                                </td>
                                            @endif
                                            <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
                                                <div class="w-full h-full flex lg:justify-center md:justify-center lg:pl-auto pl-auto justify-end">
                                                    <div x-data="{ open: false }">
                                                        <!-- MODAL BORRAR -->
                                                        <button class="color-primary flex-1" @click="open = true"><i class="fas fa-trash-alt flex-1 mr-1 hover:text-blue-200"></i></button>
                                                        <!-- Contenido  -->
                                                        <div class="absolute top-0 left-0 sm:top:1/2 flex items-center justify-center w-full h-full" x-show="open"  >
                                                            <div class="h-auto p-4 mx-1 text-left bg-primary1 rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0 border border-primary" @click.away="open = false">
                                                                <div class="mt-1">
                                                                    <div class="mt-1">
                                                                        <h1 class="text-lg text-primary">¿Deseas borrar el escenario de la aventura?</h1>
                                                                        <div class="flex">
                                                                            <button type="button" class="btn-delete-escenario border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary mr-1">Sí</button>
                                                                            <button type="button" class="border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary" @click="open = false">No</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{route('escenario.editar', $escenario)}}"><i class="fas fa-cog flex-1 hover:text-blue-200 mx-3"></i></a>
                                                </div>
                                            </td>
                                        </tr>  
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <p>Esta aventura no tiene ningún escenario asignado, ¡Pruebe a crear uno con el botón!</p>
                @endif
                
                <div class="flex justify-center">
                    <a href="{{route('escenario.crear', $aventura->id)}}" class="w-full border border-black px-4 py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center">Agregar Escenario</a>
                </div>
                <h2 class="text-2xl font-semibold leading-tight pt-5">Tabla de Personajes</h2>
                @if($personajes != NULL)
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-hidden">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal w-full">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Personaje</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Estado</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($personajes as $personaje)
                                        <tr data-id="{{ $personaje->id }}" class="bg-primary2 lg:hover:bg-secundary1 md:hover:bg-secundary1 flex lg:table-row md:table-row flex-row lg:flex-row md:flex-row flex-wrap lg:flex-no-wrap md:flex-no-wrap mb-10 lg:mb-0">
                                            <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Personaje</span>
                                                <div class="w-full h-full flex pl-auto items-center justify-end lg:justify-center md:justify-center">
                                                    <div class="flex-shrink-0 lg:ml-100 w-10 h-10">
                                                        <img class="w-full h-full rounded-full" src="{{asset($personaje->imagen)}}" alt="" />
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-primary whitespace-no-wrap">
                                                            {{$personaje->nombre}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            @if($personaje->vida > 0)
                                                <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                    <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Estado</span>
                                                    <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                        <span class="relative">Vivo</span>
                                                    </span>
                                                </td>
                                            @else
                                                <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                    <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Estado</span>
                                                    <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                        <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                        <span class="relative">Muerto</span>
                                                    </span>
                                                </td>
                                            @endif
                                            <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
                                                <div x-data="{ open: false }">
                                                    <!-- MODAL BORRAR -->
                                                    <button class="color-primary flex-1" @click="open = true"><i class="fas fa-trash-alt flex-1 mr-1 hover:text-blue-200"></i></button>
                                                    <!-- Contenido  -->
                                                    <div class="absolute top-0 left-0 sm:top:1/2 flex items-center justify-center w-full h-full" x-show="open"  >
                                                        <div class="h-auto p-4 mx-1 text-left bg-primary1 rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0 border border-primary" @click.away="open = false">
                                                            <div class="mt-1">
                                                                <div class="mt-1">
                                                                    <h1 class="text-lg text-primary">¿Deseas borrar el personaje de la aventura?</h1>
                                                                    <div class="flex">
                                                                        <button type="button" class="btn-delete border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary mr-1">Sí</button>
                                                                        <button type="button" class="border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary" @click="open = false">No</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{route('entidad.edit', $personaje->id)}}"><i class="fas fa-cog flex-1 hover:text-blue-200 mx-3"></i></a>
                                                </div>
                                            </td>
                                        </tr>  
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <p>No tienes ningún personaje en esta Aventura, ¡Pruebe a agregar uno haciendo click al botón!</p>
                @endif
                <div class="flex justify-center">
                    <a href="{{ route('aventura.personajes', $aventura->id) }}" class="w-full border border-black px-4 py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center">Agregar Personajes</a>
                </div>
            </div>
        </div>
        </div>
        <form action="{{route('aventura.remove', ':USER_ID')}}" method="POST" id="form-delete">
            @csrf
            @method("PATCH")
        </form>

        <form action="{{route('escenario.destroy', ':USER_ID')}}" method="DELETE" id="form-delete-escenario">
            @csrf
            @method("DELETE")
        </form>
    </div>
</x-app-layout>
