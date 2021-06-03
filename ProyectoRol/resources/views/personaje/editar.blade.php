<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
            {{ __('Edición de personaje') }}: {{$personaje->nombre}}
        </h2>
    </x-slot>
    
    <div class="max-w-2xl bg-secundary1 py-10 px-5 m-auto w-full mt-10 text-black">
        <form action="{{route('personaje.update', $personaje)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="text-3xl mb-6 text-center text-primary">
                Introduce la nueva foto de {{$personaje->nombre}}
            </div>

            <div class="grid grid-cols-2 gap-4 max-w-xl m-auto">

                <div class="col-span-2 lg:col-span-1 text-primary">
                    <label for="imagen">Imagen: </label><br>
                    <input type="file" id="imagen" name="imagen" />
                </div>

                <div class="col-span-2 text-right">
                    <button type="submit" class="py-3 px-6 bg-primary text-black hover:bg-primary1 hover:text-primary border border-transparent hover:border-primary rounded-lg font-bold w-full sm:w-32">
                        Subir foto
                    </button>
                </div>
            </div>  
        </form> 
    </div>
</x-app-layout>