<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Listado de objetos creados por: ') }} {{Auth::user()->name}}
        </h2>
    </x-slot>
    @push('head')
    <script>
        $(document).ready(function() {
            $('.btn-delete').click(function(e) {

                e.preventDefault();

                var row = $(this).parents('tr');
                var id = row.data('id');
                var form = $('#form-delete');
                var url = form.attr('action').replace(':USER_ID', id);
                var data = form.serialize();


                $.post(url, data, function(result) {
                   if (result == "borrado") {
                        row.fadeOut();
                   } else {
                        $("#mensaje").html("Este objeto está en uso, no se puede borrar");
                   }
                });
            });
        });
    </script>
    @endpush
    <div class="text-primary mt-6 flex">
        <div class="m-auto w-5/6 h-4/5">
            <div class="container mx-auto px-4 sm:px-8">
                <div id="mensaje" class="text-center">
                    {{$msj ?? ''}}
                 </div>
                <div class="py-8">
                    @if(!empty($objetos))
                    <h2 class="text-2xl font-semibold leading-tight">Tabla de Objetos</h2>
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-hidden">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal w-full">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Nombre</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Rango</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Tipo</th>
                                        <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($objetos as $objeto)
                                    <tr data-id="{{ $objeto->id }}" class="bg-primary2 lg:hover:bg-secundary1 md:hover:bg-secundary1 flex lg:table-row md:table-row flex-row lg:flex-row md:flex-row flex-wrap lg:flex-no-wrap md:flex-no-wrap mb-10 lg:mb-0">
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Nombre</span>
                                            <div class="w-full h-full flex pl-auto items-center justify-end lg:justify-center md:justify-center">
                                                <div class="flex-shrink-0 lg:ml-100 w-10 h-10">
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
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Rango</span>
                                            <p class="text-primary whitespace-no-wrap">
                                                {{$objeto->rango}}
                                            </p>
                                        </td>
                                        <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                            <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Tipo</span>
                                            <p class="text-primary whitespace-no-wrap">
                                                {{$objeto->tipo}}
                                            </p>
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
                                                                <h1 class="text-lg text-primary">¿Deseas borrar el objeto?</h1>
                                                                <div class="flex">
                                                                    <button type="button" class="btn-delete border border-black bg-primary text-black rounded-md justify-center flex-1 hover:bg-primary1 hover:text-primary hover:border-primary mr-1" @click="open = false">Sí</button>
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
                    </div>
                    @else
                    <p>No tienes ningún objeto creado, ¡Pruebe a agregar uno haciendo click al botón!</p>
                    @endif
                </div>
                <a href="{{route('objeto.create')}}" class="block w-full mt-2 border border-black py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center">Crear Objeto</a>
                <form action="{{route('objeto.destroy', ':USER_ID')}}" method="DELETE" id="form-delete">
                    @csrf
                    @method("DELETE")
                </form>
            </div>
        </div>
    </div>
</x-app-layout>