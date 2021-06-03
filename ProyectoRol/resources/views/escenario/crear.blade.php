<x-app-layout>
    @push('head')
        <script>
            $(document).ready(function (){
                $('.btn-close').click(function(e){
                    $("#error").hide();
                });
            });
        </script>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Creación de Escenario para ') }} '{{ $aventura->nombre}}'
        </h2>
    </x-slot>
    @if(isset($msj))
        <div class="max-w-2xl bg-red-600 py-2 px-2 m-auto w-full mt-5 text-center text-lg" id="error">
            {{$msj}}
            <button type="button" class="btn-close color-dark float-right" @click="open = false"><i class="fas fa-times"></i></button>
        </div>
    @endif
    
    <div class="max-w-2xl bg-secundary1 py-10 px-5 m-auto w-full mt-10 text-black">
        <form action="{{route('escenario.guardar', $aventura->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="text-3xl mb-6 text-center text-primary">
                Introduce los datos de tu nuevo Escenario
            </div>
            <div class="col-span-2 lg:col-span-1 block">
                <input type="text" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full block" name="nombre" placeholder="Nombre"/>
            </div>

            <div class="col-span-2 lg:col-span-1 text-primary block my-5">
                <label for="imagen">Imagen: </label><br>
                <input type="file" id="imagen" name="imagen" />
            </div>

            <div class="col-span-2 text-right">
                <button type="submit" class="block w-full border border-black py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center">
                    Crear Escenario
                </button>
            </div>
            
        </form> 
    </div>
</x-app-layout>