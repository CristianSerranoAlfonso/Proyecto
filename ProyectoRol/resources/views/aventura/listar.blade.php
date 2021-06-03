<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
        {{ __('Listado de aventuras de ') }} {{Auth::user()->name}}
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
                <h2 class="text-2xl font-semibold leading-tight">Tabla de Aventuras de Personajes</h2>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-hidden">
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal w-full">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Aventura</th>
                                    <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Personaje</th>
                                    <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    @if($user->name == Auth::user()->name)
                                        @foreach ($entidades as $entidad)
                                            @if($entidad->idUsuario == $user->id)
                                                @foreach($personajes as $personaje)
                                                    @if($personaje->idEntidad == $entidad->id)
                                                        @foreach($aventuras as $aventura)
                                                            @if($aventura->id == $personaje->idAventura)
                                                                <tr data-id="{{ $entidad->id }}" class="bg-primary2 lg:hover:bg-secundary1 md:hover:bg-secundary1 flex lg:table-row md:table-row flex-row lg:flex-row md:flex-row flex-wrap lg:flex-no-wrap md:flex-no-wrap mb-10 lg:mb-0">
                                                                    <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                                        <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Aventura</span>
                                                                            <p class="text-primary whitespace-no-wrap">
                                                                                {{$aventura->nombre}}
                                                                            </p>
                                                                    </td>
                                                                    <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                                        <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Personaje</span>
                                                                        <div class="w-full h-full flex pl-auto items-center justify-end lg:justify-center md:justify-center">
                                                                            <div class="flex-shrink-0 lg:ml-100 w-10 h-10">
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
                                                                        <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
                                                                        <a href="{{ url('aventura/tablero/'.$aventura->id) }}"><i class="fas fa-play-circle flex-1 hover:text-blue-200 mx-3"></i></a>
                                                                    </td>
                                                                </tr>  
                                                            @endif     
                                                        @endforeach
                                                    @endif
                                                @endforeach          
                                            @endif
                                        @endforeach
                                    @endif 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- SEGUNDA TABLA -->
            <div class="py-8">
                <h2 class="text-2xl font-semibold leading-tight">Tabla de Aventuras Master</h2>
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-hidden">
                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal w-full">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Aventura</th>
                                    <th class="px-5 py-3 border-b-2 font-bold uppercase bg-secundary1 text-primary border border-transparent hidden lg:table-cell md:table-cell">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    @if($user->name == Auth::user()->name)
                                        @foreach($aventuras as $aventura)
                                            @if($aventura->idUsuario == $user->id)
                                                <tr data-id="{{ $entidad->id }}" class="bg-primary2 lg:hover:bg-secundary1 md:hover:bg-secundary1 flex lg:table-row md:table-row flex-row lg:flex-row md:flex-row flex-wrap lg:flex-no-wrap md:flex-no-wrap mb-10 lg:mb-0">
                                                    <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                    <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Aventura</span>
                                                    <p class="text-primary whitespace-no-wrap">
                                                        {{$aventura->nombre}}
                                                    </p>
                                                    </td>
                                                    <td class="w-full lg:w-auto md:w-auto p-3 text-primary lg:text-center md:text-center text-right lg:border-none md:border-none border-b border-primary block lg:table-cell md:table-cell relative lg:static md:static hover:bg-secundary1">
                                                        <span class="lg:hidden md:hidden absolute top-0 left-0 bg-primary1 px-2 py-1 text-xs font-bold uppercase">Acciones</span>
                                                        <a href="{{ url('aventura/tablero/master/'.$aventura->id) }}"><i class="fas fa-play-circle flex-1 hover:text-blue-200 mx-3"></i></a>
                                                        <a href="{{route('aventura.edit', $aventura)}}"><i class="fas fa-cog flex-1 hover:text-blue-200 mx-3"></i></a>
                                                    </td>
                                                </tr>              
                                            @endif
                                        @endforeach
                                    @endif 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <a href="{{route('aventura.create')}}" class="block w-full mt-2 border border-black py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center">Crear Aventura</a>
            
        </div>
        </div>
    </div>
</x-app-layout>
