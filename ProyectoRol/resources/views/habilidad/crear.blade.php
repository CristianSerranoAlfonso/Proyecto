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
            {{ __('Creación de Habilidad') }}
        </h2>
    </x-slot>
    @if(isset($msj))
        <div class="max-w-2xl bg-red-600 py-2 px-2 m-auto w-full mt-5 text-center text-lg" id="error">
            {{$msj}}
            <button type="button" class="btn-close color-dark float-right" @click="open = false"><i class="fas fa-times"></i></button>
        </div>
    @endif
    
    <div class="max-w-2xl bg-secundary1 py-10 px-5 m-auto w-full mt-10 text-black">
        <form action="{{route('habilidad.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="text-3xl mb-6 text-center text-primary">
                Introduce los datos de la habilidad
            </div>

            <div class="grid grid-cols-2 gap-4 max-w-xl m-auto">

                <div class="col-span-2">
                    <input type="text" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="nombre" placeholder="Nombre" required/>
                </div>

                <div class="col-span-2 lg:col-span-1 text-primary -pr-7">
                    <label class="text-xl block">Facultad Negativa:</label>
                    <input type="radio" id="facultadN" name="facultadN" value="null" class="mr-1" checked>No
                    <input type="radio" id="facultadN" name="facultadN" value="Daño" class="mr-1">Daño
                    <input type="radio" id="facultadN" name="facultadN" value="Vida" class="mr-1">Vida
                    <input type="radio" id="facultadN" name="facultadN" value="Precision" class="mr-1">Precisión
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="facultadNB" placeholder="Base Facultad Negativa" required/>
                </div>

                <div class="col-span-2 text-primary -pr-7">
                    <label class="text-xl block">Escalado:</label>
                    <input type="radio" id="facultadP" name="facultadP" value="Fuerza" class="mr-1" checked>Fuerza
                    <input type="radio" id="facultadP" name="facultadP" value="Destreza" class="mr-1">Destreza
                    <input type="radio" id="facultadP" name="facultadP" value="Inteligencia" class="mr-1">Inteligencia
                    <input type="radio" id="facultadP" name="facultadP" value="Sabiduria" class="mr-1">Sabiduría
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="nivel" placeholder="Nivel" required/>
                </div>

                <div class="col-span-2 lg:col-span-1 text-primary -pr-7">
                    <label class="text-xl block">Área:</label>
                    <input type="radio" id="area" name="area" value="no" class="mr-1" checked>No
                    <input type="radio" id="area" name="area" value="si" class="mr-1">Sí
                </div>

                <div class="col-span-2 text-primary -pr-7">
                    <label class="text-xl block">Dado:</label>
                    <input type="radio" id="dado" name="dado" value="4" class="mr-1" checked>D4
                    <input type="radio" id="dado" name="dado" value="6" class="mr-1">D6
                    <input type="radio" id="dado" name="dado" value="8" class="mr-1">D8
                    <input type="radio" id="dado" name="dado" value="10" class="mr-1">D10
                    <input type="radio" id="dado" name="dado" value="12" class="mr-1">D12
                    <input type="radio" id="dado" name="dado" value="20" class="mr-1">D20
                    <input type="radio" id="dado" name="dado" value="100" class="mr-1">D100
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <input type="number" min="0" class="border-solid border-gray-400 border-2 p-3 md:text-xl w-full" name="valor" placeholder="Valor Base" required/>
                </div>

                <div class="col-span-2 lg:col-span-1 text-primary -pr-7">
                    <label class="text-xl block">Tipo:</label>
                    <input type="radio" id="tipo" name="tipo" value="daño" class="mr-1" checked>Daño
                    <input type="radio" id="tipo" name="tipo" value="cura" class="mr-1">Cura
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