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
            {{ __('Creación de Personaje') }}
        </h2>
    </x-slot>
    @if(isset($msj))
        <div class="max-w-2xl bg-red-600 py-2 px-2 m-auto w-full mt-5 text-center text-lg" id="error">
            {{$msj}}
            <button type="button" class="btn-close color-dark float-right" @click="open = false"><i class="fas fa-times"></i></button>
        </div>
    @endif
    
    <div class="max-w-2xl bg-secundary1 py-10 px-5 m-auto w-full mt-10 text-black">
        <form action="{{route('personaje.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="text-3xl mb-6 text-center text-primary">
                Introduce los datos de tu nuevo Personaje
            </div>

            <div class="grid grid-cols-2 gap-4 max-w-xl m-auto">

                <div class="col-span-2 lg:col-span-1">
                    <input type="text" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="nombre" placeholder="Nombre"/>
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="text" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="deidad" placeholder="Deidad"/>
                </div>

                <div class="col-span-2 lg:col-span-1 text-primary -pr-7">
                    <label class="text-xl block">Sexo:</label>
                    <input type="radio" id="sexo" name="sexo" value="Male" class="mr-1">Hombre
                    <input type="radio" id="sexo" name="sexo" value="Female" class="mr-1">Mujer
                </div>
                
                <div class="col-span-2">
                    <textarea cols="30" rows="8" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="historia" placeholder="Historia"></textarea>
                </div>

                <div class="col-span-2 lg:col-span-1 text-primary">
                    <label for="imagen">Imagen: </label><br>
                    <input type="file" id="imagen" name="imagen" />
                </div>

                <div class="col-span-2 text-right">
                    <button type="submit" class="py-3 px-6 bg-primary text-black hover:bg-primary1 hover:text-primary border border-transparent hover:border-primary rounded-lg font-bold w-full sm:w-32">
                        Crear
                    </button>
                </div>
                <input type="hidden" name="us" value="{{ Auth::user()->id }}">
            </div>  
        </form> 
    </div>
</x-app-layout>