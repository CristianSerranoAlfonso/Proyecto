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
            {{ __('Creación de Objeto') }}
        </h2>
    </x-slot>
    @if(isset($msj))
        <div class="max-w-2xl bg-red-600 py-2 px-2 m-auto w-full mt-5 text-center text-lg" id="error">
            {{$msj}}
            <button type="button" class="btn-close color-dark float-right" @click="open = false"><i class="fas fa-times"></i></button>
        </div>
    @endif
    
    <div class="max-w-2xl bg-secundary1 py-10 px-5 m-auto w-full mt-10 text-black">
        <form action="{{route('objeto.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="text-3xl mb-6 text-center text-primary">
                Introduce los datos del nuevo Objeto
            </div>

            <div class="grid grid-cols-2 gap-4 max-w-xl m-auto">

                <div class="col-span-2">
                    <input type="text" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="nombre" placeholder="Nombre" required/>
                </div>

                <div class="col-span-2 lg:col-span-1 text-primary -pr-7">
                    <label class="text-xl block">Rango:</label>
                    <input type="radio" id="rango" name="rango" value="Normal" class="mr-1" checked>Normal
                    <input type="radio" id="rango" name="rango" value="Epico" class="mr-1">Épico
                    <input type="radio" id="rango" name="rango" value="Legendario" class="mr-1">Legendario
                </div>

                <div class="col-span-2 lg:col-span-1 text-primary -pr-7">
                    <label class="text-xl block">Tipo:</label>
                    <input type="radio" id="tipo" name="tipo" value="Arma" class="mr-1" checked>Arma
                    <input type="radio" id="tipo" name="tipo" value="Armadura" class="mr-1">Armadura
                    <input type="radio" id="tipo" name="tipo" value="Abalorio" class="mr-1">Abalorio
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="armadura" placeholder="Armadura" required/>
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="fuerza" placeholder="Fuerza" required/>
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="destreza" placeholder="Destreza" required/>
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="inteligencia" placeholder="Inteligencia" required/>
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="cordura" placeholder="Cordura" required/>
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="sabiduria" placeholder="Sabiduría" required/>
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="evasion" placeholder="Evasión" required/>
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="precio" placeholder="Precio" required/>
                </div>

                <div class="col-span-2">
                    <textarea cols="30" rows="8" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="descripcion" placeholder="Descripción del objeto" required></textarea>
                </div>
                
                <div class="col-span-2 lg:col-span-1 text-primary">
                    <label for="imagen">Imagen: </label><br>
                    <input type="file" id="imagen" name="imagen" />
                </div>

                <div class="col-span-2 text-right">
                    <button type="submit" class="block w-full mt-2 border border-black py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center">
                        Crear
                    </button>
                </div>
            </div>  
        </form> 
    </div>
</x-app-layout>