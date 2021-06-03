<x-app-layout>
    @push('head')

    <script>
        $(document).ready(function() {
            $('.btn-delete-objeto').click(function(e) {

                e.preventDefault();

                var row = $(this).parents('tr');
                var id = row.data('id');
                var form = $('#form-delete-objeto');
                var url = form.attr('action').replace(':USER_ID', id);
                var data = form.serialize();

                row.fadeOut();

                $.post(url, data, function(result) {
                    alert(result);
                });
            });

            $('.btn-delete-habilidad').click(function(e) {

                e.preventDefault();

                var row = $(this).parents('tr');
                var id = row.data('id');
                var form = $('#form-delete-habilidad');
                var url = form.attr('action').replace(':USER_ID', id);
                var data = form.serialize();

                row.fadeOut();

                $.post(url, data, function(result) {
                    alert(result);
                });
            });
        });
    </script>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Gestión de entidad:') }} '{{$entidad->nombre}}'
        </h2>
    </x-slot>
    @if(isset($msj))
    <div class="max-w-2xl bg-red-600 py-2 px-2 m-auto w-full mt-5 text-center text-lg" id="error">
        {{$msj}}
        <button type="button" class="btn-close color-dark float-right" @click="open = false"><i class="fas fa-times"></i></button>
    </div>
    @endif
    <div class="text-primary mt-6 flex">
        <div class="m-auto w-5/6 h-4/5">
            <div class="container mx-auto px-4 sm:px-8">
                <div class="py-8">
                    @if(!empty($objetosEnemigo))
                    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-secundary1">
                        <table class="min-w-full leading-normal w-full">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Nombre</th>
                                    <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Tipo</th>
                                    <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Rango</th>
                                    <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($objetosEnemigo as $objeto)
                                <tr data-id="{{ $objeto->id }}" class="bg-primary2 lg:hover:bg-secundary1 md:hover:bg-secundary1 flex lg:table-row md:table-row flex-row lg:flex-row md:flex-row flex-wrap lg:flex-no-wrap md:flex-no-wrap mb-10 lg:mb-0">
                                    <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                        <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
                                        <div class="flex lg:justify-center md:justify-center items-center lg:float-none md:float-none float-right">
                                            <div class="flex-shrink-0 w-10 h-10">
                                                <img class="w-full h-full rounded-full" src="{{asset($objeto->imagen)}}" alt="" />
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-primary whitespace-no-wrap">
                                                    {{$objeto->nombre}}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                        <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Tipo</span>
                                        <p class="text-primary whitespace-no-wrap">
                                            {{$objeto->tipo}}
                                        </p>
                                    </td>
                                    <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                        <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Rango</span>
                                        <p class="text-primary whitespace-no-wrap">
                                            {{$objeto->rango}}
                                        </p>
                                    </td>
                                    <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                        <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
                                        <div class="w-full h-full flex lg:justify-center md:justify-center lg:pl-auto pl-auto justify-end">
                                            <div x-data="{ open: false }">
                                                <!-- MODAL BORRAR -->
                                                <button class="color-primary flex-1" @click="open = true"><i class="fas fa-trash-alt flex-1 mr-1 hover:text-blue-200"></i></button>
                                                <!-- Contenido  -->
                                                <div class="absolute top-0 left-0 sm:top:1/2 flex items-center justify-center w-full h-full" x-show="open">
                                                    <div class="h-auto p-4 mx-1 text-left bg-primary1 rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0 border border-primary" @click.away="open = false">
                                                        <div class="mt-1">
                                                            <div class="mt-1">
                                                                <h1 class="text-lg text-primary">¿Deseas borrar el objeto?</h1>
                                                                <div class="flex">
                                                                    <button type="button" class="btn-delete-objeto border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary mr-1">Sí</button>
                                                                    <button type="button" class="border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary" @click="open = false">No</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p>No existen objetos ligados a este enemigo, pruebe a crear uno o añadir de los ya existentes!<p>
                    @endif
                    @if($tipo == "enemigo")
                        <a href="{{ route('enemigo.objeto', $entidad->id)}}" class="my-2 block w-full border border-black py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center">Añadir Objetos</a>
                    @endif
                    @if(!empty($habilidades))
                    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-secundary1">
                    <table class="min-w-full leading-normal w-full">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Nombre</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Nivel</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Dado</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Escalado</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Base</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Tipo</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Área</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($habilidades as $habilidad)
                                    <tr data-id="{{ $habilidad->id }}" class="bg-primary2 lg:hover:bg-secundary1 md:hover:bg-secundary1 flex lg:table-row md:table-row flex-row lg:flex-row md:flex-row flex-wrap lg:flex-no-wrap md:flex-no-wrap mb-10 lg:mb-0">
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                        <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
                                            <p class="text-primary whitespace-no-wrap">
                                                {{$habilidad->nombre}}
                                            </p>
                                        </td>
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Nivel</span>
                                            <p class="text-primary whitespace-no-wrap">
                                                {{$habilidad->nivelHabilidad}}
                                            </p>
                                        </td>
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Dado</span>
                                            <p class="text-primary whitespace-no-wrap">
                                                {{$habilidad->dado}}
                                            </p>
                                        </td>
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Escalado</span>
                                            <p class="text-primary whitespace-no-wrap">
                                                {{$habilidad->facultadPositiva}}
                                            </p>
                                        </td>
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Base</span>
                                            <p class="text-primary whitespace-no-wrap">
                                                {{$habilidad->valorBase}}
                                            </p>
                                        </td>
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Tipo</span>
                                            @if($habilidad->ataque == 0)
                                                <p class="text-primary whitespace-no-wrap">
                                                    Cura
                                                </p>
                                            @else
                                                <p class="text-primary whitespace-no-wrap">
                                                    Daño
                                                </p>
                                            @endif
                                        </td>
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Área</span>
                                            @if($habilidad->area == 0)
                                                <p class="text-primary whitespace-no-wrap">
                                                    No
                                                </p>
                                            @else
                                                <p class="text-primary whitespace-no-wrap">
                                                    Sí
                                                </p>
                                            @endif
                                        </td>
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
                                            <div x-data="{ open: false }">
                                                <!-- MODAL BORRAR -->
                                                <button class="color-primary flex-1" @click="open = true"><i class="fas fa-trash-alt flex-1 mr-1 hover:text-blue-200"></i></button>
                                                <!-- Contenido  -->
                                                <div class="absolute top-0 left-0 sm:top:1/2 flex items-center justify-center w-full h-full" x-show="open">
                                                    <div class="h-auto p-4 mx-1 text-left bg-primary1 rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0 border border-primary" @click.away="open = false">
                                                        <div class="mt-1">
                                                            <div class="mt-1">
                                                                <h1 class="text-lg text-primary">¿Deseas borrar la habilidad?</h1>
                                                                <div class="flex">
                                                                    <button type="button" class="btn-delete-habilidad border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary mr-1" @click="open = false">Sí</button>
                                                                    <button type="button" class="border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary" @click="open = false">No</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No existen habilidades ligadas a esta entidad, pruebe a crear una o añadir de las ya existentes!<p>
                    @endif
                    <a href="{{ route('entidad.habilidad', $entidad)}}" class="block w-full mt-2 border border-black py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center">Añadir Habilidades</a>

                </div>
                <form action="{{ route('eliminar_objEntidad', ':USER_ID')}}" method="DELETE" id="form-delete-objeto">
                    @csrf
                    @method("DELETE")
                    <input type="hidden" name="entidad" value="{{$entidad->id}}">
                </form>
                <form action="{{ route('eliminar_habEntidad', ':USER_ID')}}" method="DELETE" id="form-delete-habilidad">
                    @csrf
                    @method("DELETE")
                    <input type="hidden" name="entidad" value="{{$entidad->id}}">
                </form>
            </div>
        </div>
    </div>
</x-app-layout>