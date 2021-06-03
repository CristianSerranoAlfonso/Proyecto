<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Listado de personajes de ') }} {{Auth::user()->name}}
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
            <div>
                <h2 class="text-2xl font-semibold leading-tight">Tabla de Personajes</h2>
            </div>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-hidden">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal w-full">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Personaje</th>
                                <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Nivel</th>
                                <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Aventura Actual</th>
                                <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Estado</th>
                                <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @if($user->name == Auth::user()->name)
                                    @foreach ($entidades as $entidad)
                                        @foreach($personajes as $personaje)
                                        @if($entidad->idUsuario == $user->id)
                                        @if($entidad->id == $personaje->idEntidad)
                                            <tr data-id="{{ $entidad->id }}" class="bg-primary2 lg:hover:bg-secundary1 md:hover:bg-secundary1 flex lg:table-row md:table-row flex-row lg:flex-row md:flex-row flex-wrap lg:flex-no-wrap md:flex-no-wrap mb-10 lg:mb-0">
                                                <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                    <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Personaje</span>
                                                    <div class="flex items-center lg:float-none md:float-none float-right">
                                                        <div class="flex-shrink-0 w-10 h-10">
                                                            <img class="w-full h-full rounded-full"
                                                            src="{{asset($entidad->imagen)}}"
                                                            alt="" />
                                                        </div>
                                                        <div class="ml-3">
                                                            <p class="text-primary whitespace-no-wrap">
                                                                {{$entidad->nombre}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>   
                                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Nivel</span>
                                                            <p class="text-primary whitespace-no-wrap">{{$personaje->nivel}}</p>
                                                        </td>
                                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Aventura Actual</span>
                                                            @foreach($aventuras as $aventura)
                                                                @if($aventura->id == $personaje->idAventura)
                                                                    <p class="text-primary whitespace-no-wrap">{{$aventura->nombre}}</p>
                                                                @endif
                                                            @endforeach
                                                            @if($personaje->idAventura == NULL)
                                                                <p class="whitespace-no-wrap text-red-600">Ninguna</p>
                                                            @endif
                                                        </td>
                                                        @if($entidad->vida > 0)
                                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Estado</span>
                                                            <span
                                                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                                <span aria-hidden
                                                                    class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                                <span class="relative">Vivo</span>
                                                            </span>
                                                        </td>
                                                        @else
                                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Estado</span>
                                                            <span
                                                                class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                                <span aria-hidden
                                                                    class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                                <span class="relative">Muerto</span>
                                                            </span>
                                                        </td>
                                                        @endif
                                                        <td class="w-full lg:w-auto md:w-auto py-3 px-5 text-primary lg:text-center md:text-center text-right border border-transparent block lg:table-cell md:table-cell relative lg:static md:static flex space-x-4 justify-right hover:bg-secundary1">
                                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
                                                            <div class="w-full h-full flex lg:justify-around lg:justify-center md:justify-center lg:pl-auto pl-auto justify-end">
                                                            <div x-data="{ open: false }">
                                                            <!-- MODAL --> 
                                                                <button class="invisible lg:visible md:visible color-primary flex-1" @click="open = true"><i class="fas fa-info-circle hover:text-blue-200"></i></button>
                                                                <!-- Contenido  -->
                                                                <div class="absolute top-0 left-0 flex items-center justify-center w-full h-full text-primary" x-show="open"  >
                                                                    <div class="h-auto p-4 mx-2 text-left bg-ficha bg-cover rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0 z-40" @click.away="open = false">
                                                                        <div class="mt-1">
                                                                            <div class="mt-1">
                                                                                <p class="text-sm leading-5 text-primary">
                                                                                    @foreach($personajes as $personaje)
                                                                                        @if($personaje->idEntidad == $entidad->id)
                                                                                            <div class="flex space-x-4">
                                                                                                <div class="inline flex-1 ml-6 mt-4">
                                                                                                    <div class="font-bold inline mb-3">Nombre: {{$entidad->nombre}}</div>
                                                                                                    <br />
                                                                                                    <div class="font-bold inline mb-3">Nivel: {{$personaje->nivel}}</div>
                                                                                                    <br />
                                                                                                    <div class="font-bold inline mb-3">Sexo: {{$entidad->sexo}}</div>
                                                                                                    <br />
                                                                                                    <div class="font-bold inline">Deidad: {{$entidad->deidad}}</div>
                                                                                                </div>
                                                                                                <img src="{{asset($entidad->imagen)}}" height="120px" width="120px" class="flex-1" />            
                                                                                            </div>

                                                                                            <table class="table-auto border-separate mb-6 mt-4 float-right text-center ml-56">
                                                                                                <thead>
                                                                                                    <tr class="bg-primary text-black border border-black font-medium font-bold">
                                                                                                        <th>Atributo</th>
                                                                                                        <th>Valor</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody class="bg-primary1">
                                                                                                    <tr class="hover:text-black hover:bg-primary">
                                                                                                        <td class="border border-primary font-medium font-bold">Vida</td>
                                                                                                        <td class="border border-primary font-medium">{{$entidad->vida}}</td>
                                                                                                    </tr>
                                                                                                    <tr class="hover:text-black hover:bg-primary">
                                                                                                        <td class="border border-primary font-medium font-bold">Armadura</td>
                                                                                                        <td class="border border-primary font-medium">{{$personaje->armadura}}</td>
                                                                                                    </tr>
                                                                                                    <tr class="hover:text-black hover:bg-primary">
                                                                                                        <td class="border border-primary font-medium font-bold">Fuerza</td>
                                                                                                        <td class="border border-primary font-medium">{{$personaje->fuerza}}</td>
                                                                                                    </tr>
                                                                                                    <tr class="hover:text-black hover:bg-primary">
                                                                                                        <td class="border border-primary font-medium font-bold">Destreza</td>
                                                                                                        <td class="border border-primary font-medium">{{$personaje->destreza}}</td>
                                                                                                    </tr>
                                                                                                    <tr class="hover:text-black hover:bg-primary">
                                                                                                        <td class="border border-primary font-medium font-bold">Inteligencia</td>
                                                                                                        <td class="border border-primary font-medium">{{$personaje->inteligencia}}</td>
                                                                                                    </tr>
                                                                                                    <tr class="hover:text-black hover:bg-primary">
                                                                                                        <td class="border border-primary font-medium font-bold">Cordura</td>
                                                                                                        <td class="border border-primary font-medium">{{$personaje->cordura}}</td>
                                                                                                    </tr>
                                                                                                    <tr class="hover:text-black hover:bg-primary">
                                                                                                        <td class="border border-primary font-medium font-bold">Sabiduría</td>
                                                                                                        <td class="border border-primary font-medium">{{$personaje->sabiduria}}</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <div class="mt-32 ml-4">
                                                                                                @foreach($objetosentidad as $objetoentidad)
                                                                                                    @if($objetoentidad->entidad_id == $entidad->id)
                                                                                                        @foreach($objetos as $objeto)
                                                                                                            @if($objeto->id == $objetoentidad->objeto_id)
                                                                                                                <div class="my-2">
                                                                                                                    <img src="{{asset($objeto->imagen)}}" height="50px" width="50px" class="inline"/>
                                                                                                                    <div class="inline">{{$objeto->nombre}}</div>
                                                                                                                    <br />
                                                                                                                </div>
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- FIN MODAL  -->
                                                            <a href="{{route('personaje.edit', $entidad)}}"><i class="fas fa-edit flex-1 hover:text-blue-200 mx-3"></i></a>
                                                            <div x-data="{ open: false }">
                                                            <!-- MODAL BORRAR -->
                                                                <button class="color-primary flex-1" @click="open = true"><i class="fas fa-trash-alt flex-1 mr-1 hover:text-blue-200"></i></button>
                                                                <!-- Contenido  -->
                                                                <div class="absolute top-0 left-0 sm:top:1/2 flex items-center justify-center w-full h-full" x-show="open"  >
                                                                    <div class="h-auto p-4 mx-1 text-left bg-primary1 rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0 border border-primary" @click.away="open = false">
                                                                        <div class="mt-1">
                                                                            <div class="mt-1">
                                                                                <h1 class="text-lg text-primary">¿Deseas borrar el personaje?</h1>
                                                                                <div class="flex">
                                                                                    <button type="button" class="btn-delete border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary mr-1">Sí</button>
                                                                                    <button type="button" class="border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary" @click="open = false">No</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- FIN MODAL BORRAR  -->
                                                            </div>
                                                        </td>
                                            </tr>
                                            
                                            @endif
                                            
                                        @endif
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <button class="w-all">
        <a href="{{route('personaje.create')}}" class="border border-black px-2 py-1 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary">Crear Personaje</a>
    </button>
    </div>
        <form action="{{route('entidad.destroy', ':USER_ID')}}" method="DELETE" id="form-delete">
            @csrf
            @method("DELETE")
            <input type="hidden" value="{{ Auth::user()->id }}" name="idusuario">
        </form>
    </div>
</x-app-layout>
