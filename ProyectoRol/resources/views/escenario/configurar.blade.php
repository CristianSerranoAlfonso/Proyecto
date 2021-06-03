<x-app-layout>
    @push('head')
    <script>
        $(document).ready(function() {
            $('.btn-close').click(function(e) {
                $("#error").hide();
            });

            $('.btn-delete-enemigo').click(function(e) {

                e.preventDefault();

                var row = $(this).parents('tr');
                var id = row.data('id');
                var form = $('#form-delete-enemigos');
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
            {{ __('Gestión de escenario:') }} '{{$escenario->nombre}}'
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
            @if(!$escenario->activo)
                <div class="font-semibold text-xl text-primary color-primary">
                    <h2 class="text-2xl font-semibold leading-tight">Activar Aventura: </h2>
                    <form action="{{route('escenario.activar', $escenario->id)}}" method="POST">
                        @csrf
                        @method("PATCH")
                        <input type="hidden" value="{{$escenario->idAventura}}" name="aventura">
                        <input type="submit" value="Activar" name="submit" class="py-3 px-6 bg-primary text-black hover:bg-primary1 hover:text-primary border border-transparent hover:border-primary rounded-lg font-bold w-full sm:w-32 cursor-pointer">
                    </form>
                </div>
            @endif
                <div class="py-8">
                    <h2 class="text-2xl font-semibold leading-tight">Tabla de Enemigos en: {{$escenario->nombre}}</h2>
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-hidden">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            @if(empty($enemigos))
                            No existen enemigos ligados a esa aventura, prueba a crear uno nuevo!
                            @else
                            <table class="min-w-full leading-normal w-full">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Nombre</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Tipo</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Estado</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Acciones</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($entidades as $entidad)
                                    @foreach ($enemigos as $enemigo)
                                    @if ($enemigo->idEntidad == $entidad->id)
                                    <tr data-id="{{ $entidad->id }}" class="bg-primary2 lg:hover:bg-secundary1 md:hover:bg-secundary1 flex lg:table-row md:table-row flex-row lg:flex-row md:flex-row flex-wrap lg:flex-no-wrap md:flex-no-wrap mb-10 lg:mb-0">
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
                                            <div class="flex lg:justify-center md:justify-center items-center lg:float-none md:float-none float-right">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-full h-full rounded-full" src="{{asset($entidad->imagen)}}" alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-primary whitespace-no-wrap">
                                                        {{$entidad->nombre}}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Tipo</span>
                                            <p class="text-primary whitespace-no-wrap">
                                                @if ($enemigo->jefe == 1)
                                                Jefe
                                                @else
                                                Normal
                                                @endif
                                            </p>
                                        </td>
                                        @if($entidad->vida > 0)
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
                                            <div class="w-full h-full flex lg:justify-center md:justify-center lg:pl-auto pl-auto justify-end">
                                                <a href="{{ route('entidad.edit', $entidad->id) }}"><i class="fas fa-cog flex-1 hover:text-blue-200 mx-3"></i></a>
                                                <div x-data="{ open: false }">
                                                    <!-- MODAL BORRAR -->
                                                    <button class="color-primary flex-1" @click="open = true"><i class="fas fa-trash-alt flex-1 mr-1 hover:text-blue-200"></i></button>
                                                    <!-- Contenido  -->
                                                    <div class="absolute top-0 left-0 sm:top:1/2 flex items-center justify-center w-full h-full" x-show="open">
                                                        <div class="h-auto p-4 mx-1 text-left bg-primary1 rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0 border border-primary" @click.away="open = false">
                                                            <div class="mt-1">
                                                                <div class="mt-1">
                                                                    <h1 class="text-lg text-primary">¿Deseas borrar el enemigo?</h1>
                                                                    <div class="flex">
                                                                        <button type="button" class="btn-delete-enemigo border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary mr-1">Sí</button>
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
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{route('enemigo.crear', $escenario->id)}}" class="block w-full mt-2 border border-black py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center">Crear Enemigo</a>
        </div>
    </div>
    <form action="{{route('entidad.destroy', ':USER_ID')}}" method="DELETE" id="form-delete-enemigos">
        @csrf
        @method("DELETE")
    </form>
</x-app-layout>