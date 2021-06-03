<x-app-layout>
@push('head')
    <style>
        #tablero
        {
            position: relative;
            height: 600px;
            width: 600px;
            border: solid 1px black;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .imgJugador, .imgEnemigo
        {
            height: 50px;
            width: 50px;
        }
        .imgJefe, .logo
        {
            height: 100px;
            width: 100px;
        }
        
    </style>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/utils/Draggable.min.js"></script>
    <script>
    function cargarProta(img)
{
    var prota = img.getAttribute('id');

    var parametros = {
        "prota" : prota,
        "_token": "{{ csrf_token() }}"
    };
    $.ajax({
        url: "{{route('mostrar.prota')}}",
        type: "POST",
        data: parametros,
        dataType: 'JSON',
        success: function (data) {
            if (data != 0) {
                var contenedor = "<div id='nombre' class='text-center text-primary font-extrabold text-lg'>"+data.nombre+"</div>";
                contenedor += "<img class='logo mx-auto prota' id="+data.id+" src='{{asset("+imagen+")}}'>";
                contenedor += "<div id='vida' class='text-primary text-center font-extrabold'>"+data.vida+"/20</div>";

                contenedor = contenedor.replace('+imagen', data.imagen);
                contenedor = contenedor.replace('png+', 'png');
                $('#contenedor-img').html(contenedor);
                $('#foco').html('');
                $('#lanzarHabilidades').html(''); 
                cargarHabilidades(data.id);
            }      
        }
    });
}
function cargarHabilidades(entidad)
{
    var parametros = {
        "prota" : entidad,
        "_token": "{{ csrf_token() }}"
    };

    $.ajax({
        url: "{{route('mostrar.habilidades')}}",
        type: "POST",
        data: parametros,
        dataType: 'JSON',
        success: function (data) {
            var size = Object.keys(data).length;
            var habilidades = "<p class='text-primary font-extrabold'> Habilidades: </p>";
            habilidades+= "<div class='flex flex-row items-center'><select id='habilidades' name='habilidades' class='mr-2 bg-primary1 border-primary text-primary flex-grow'>";
            for(var i = 0; i < size; i++) {
               habilidades += "<option value='"+data[i].id+"' class='text-primary'>"+data[i].nombre+"</option>"; 
            }  
            habilidades += "</select></div>";
            $('#contenedor-habilidades').html(habilidades);
        }
    });
}
function almacenarMovimiento(img)
{
    var posX = img.style.left;
    var posY = img.style.top;
    posX = posX.substring(0, posX.length -2);
    posY = posY.substring(0, posY.length -2);
    var id = img.id;
    var parametros = {
        "posX" : posX,
        "posY" : posY,
        "_token": "{{ csrf_token() }}"
    };
    var ruta = "{{route('entidad.almacenarMovimiento',"+id+")}}";
    ruta = ruta.replace('+id+', id);
    $.ajax({
        url: ruta,
        type: "PATCH",
        data: parametros,
        dataType: 'JSON',
    });
}
function cargarPersonajes()
{
    $.ajax({
        url: "{{route('entidad.cargarPersonajes', $aventura->id)}}",
        type: "GET",
        dataType: 'JSON',
        success: function (data) {
            var size = Object.keys(data).length;
            for(var i = 0; i < size; i++) {
                var personaje = "<img src={{asset("+imagen+")}} class='imgJugador imgJ ficha mov' id='"+data[i].id+"' style='position:absolute;left:"+data[i].posX+"px;top:"+data[i].posY+"px;' onclick='almacenarMovimiento(this);cargarProta(this)' oncontextmenu='foco(this)'/>";
                personaje = personaje.replace('+imagen', data[i].imagen);
                personaje = personaje.replace('png+', 'png');
                $('#tablero').append(personaje);
                $('.mov').draggable({
                    containment: "parent"                                
                });
            }
        }
    });
}
function actualizarEntidades()
{
    $.ajax({
        url: "{{route('entidad.cargarEntidades', $aventura->id)}}",
        type: "GET",
        dataType: 'JSON',
        success: function (data) {
            var imagenes = document.getElementsByClassName("ficha");
            var size = Object.keys(data).length;
            var size2 = imagenes.length;
            var idImagen, estilo;
            for(var x = 0; x < size2; x++) {
                if (imagenes[x] != undefined) {
                    idImagen = imagenes[x].getAttribute("id");
                    for(var i = 0; i < size; i++) {
                        if(idImagen == data[i].id) {
                            estilo = "position:absolute;left:" + data[i].posX + "px; top:"+data[i].posY+"px";
                            imagenes[x].setAttribute("style", estilo);
                            if(data[i].vida <= 0) {
                                imagenes[x].parentNode.removeChild(imagenes[x]);
                            }
                        }
                    }
                }
            }
            cargarTiradas();
        }
    });
}
function cargarTiradas()
{
    $.ajax({
        url: "{{route('aventura.cargarTiradas', $escenario->id)}}",
        type: "GET",
        dataType: 'JSON',
        success: function (data) {
            $('#cajaComentarios').html('');
            var size = Object.keys(data).length;
            for(var i = 0; i < size; i++) {
                $('#cajaComentarios').append(data[i]);
                $('#cajaComentarios').append("<br><br><hr>");
            }
        }
    });
}
function cargarEnemigos()
{
    $.ajax({
        url: "{{route('entidad.cargarEnemigos', $escenario->id)}}",
        type: "GET",
        dataType: 'JSON',
        success: function (data) {
            var size = Object.keys(data).length;
            for(var i = 0; i < size; i++) {
                var enemigo = "<img src={{asset("+imagen+")}} class='imgEnemigo mov imgE ficha' id='"+data[i].id+"' style='position:absolute;left:"+data[i].posX+"px;top:"+data[i].posY+"px;' onclick='almacenarMovimiento(this);cargarProta(this)' oncontextmenu='foco(this)'/>";
                var src = data[i].imagen;
                src = src.replace(' ', '');
                enemigo = enemigo.replace('+imagen', src);
                enemigo = enemigo.replace('png+', 'png');
                $('#tablero').append(enemigo);
                $('.mov').draggable({
                    containment: "parent"                                
                });
            }
        }
    });
}
function cargarJefes()
{
    $.ajax({
        url: "{{route('entidad.cargarJefes', $escenario->id)}}",
        type: "GET",
        dataType: 'JSON',
        success: function (data) {
            var size = Object.keys(data).length;
            for(var i = 0; i < size; i++) {
                var enemigo = "<img src={{asset("+imagen+")}} class='imgJefe imgE mov ficha' id='"+data[i].id+"' style='position:absolute;left:"+data[i].posX+"px;top:"+data[i].posY+"px;' onclick='almacenarMovimiento(this);cargarProta(this)' oncontextmenu='foco(this)'/>";
                var src = data[i].imagen;
                src = src.replace(' ', '');
                enemigo = enemigo.replace('+imagen', src);
                enemigo = enemigo.replace('png+', 'png');
                $('#tablero').append(enemigo);
                $('.mov').draggable({
                    containment: "parent"                                
                });
            }
        }
    });
}
function foco(img) 
{
    var prota = document.getElementsByClassName('prota');
    prota = prota[0].getAttribute('id');
    var indiceHabilidad = document.getElementById('habilidades').selectedIndex;
    var habilidad = document.getElementById('habilidades').options[indiceHabilidad].value;
    var id = img.getAttribute('id');
    var parametros = {
        "id" : habilidad,
        "idEntidad" : id,
        "prota" : prota
    };
    var ruta = "{{route('aventura.cargarFoco', $escenario->id)}}";
    ruta = ruta.replace('+id+', id);
    $.ajax({
        url: ruta,
        type: "GET",
        data: parametros,
        dataType: 'JSON',
        success: function (data) {
            var imagen;
            switch(data){
                case "No puedes pegar a tus aliados":
                case "No puedes curar a tus enemigos":
                    $('#foco').html(data);
                    break;
                default:
                    $('#foco').html('');
                    $('#lanzarHabilidades').html(''); 
                    if (data.id == undefined) {
                        var size = Object.keys(data).length;
                        for(var i = 0; i < size; i++) {
                            imagen = "<div class='flex-1'><img class='logo inline foco' id='idImagen' src='{{asset("+imagen+")}}'/>"
                            var src = data[i].imagen;
                            var idI = data[i].id;
                            var vida = data[i].vida;
                            imagen = imagen.replace('+imagen', src);
                            imagen = imagen.replace('png+', 'png');
                            imagen = imagen.replace('idImagen', idI);
                            imagen+= "<p>"+vida+"</p></div>";
                            $('#foco').append(imagen);
                        }
                    } else {
                        imagen = "<div class='flex-1'><img class='logo inline foco' id='idImagen' src='{{asset("+imagen+")}}'/>"
                        var src = data.imagen;
                        var idI = data.id;
                        var vida = data.vida;
                        imagen = imagen.replace('+imagen', src);
                        imagen = imagen.replace('png+', 'png');
                            imagen = imagen.replace('idImagen', idI);
                        imagen+= "<p>"+vida+"</p></div>";
                        $('#foco').html(imagen);
                    }
                    var boton = "<button type='button' id='lanzar' class='block w-full mt-2 border border-black py-2 bg-primary text-black rounded-md hover:bg-primary2 hover:border-primary hover:text-primary text-center' onclick='lanzarHabilidad()' >Lanzar Habilidad</button>";
                    $('#lanzarHabilidades').append(boton);     
            }
        }
    });
}
function lanzarHabilidad()
{
    var prota = document.getElementsByClassName('prota');
    prota = prota[0].getAttribute('id');
    let imagenes = document.getElementsByClassName('foco');
    let idImagenes = [];
    for(var i = 0; i <= imagenes.length-1; i++) {
        idImagenes[i] = imagenes[i].getAttribute('id');
    }
    var indiceHabilidad = document.getElementById('habilidades').selectedIndex;
    var habilidad = document.getElementById('habilidades').options[indiceHabilidad].value;
    var parametros = {
        "idEntidades" : idImagenes,
        "habilidad" : habilidad,
        "prota" : prota
    };
    var ruta = "{{route('aventura.lanzarHabilidad', $aventura->id)}}";
    $.ajax({
        url: ruta,
        type: "GET",
        data: parametros,
        dataType: 'JSON',
        success: function (data) {
            var entidad = document.getElementById('nombre').innerHTML;
            var indiceHabilidad = document.getElementById('habilidades').selectedIndex;
            var habilidad = document.getElementById('habilidades').options[indiceHabilidad].value;
            var tirada = 10;
            var foco = [];
            let imagenes = document.getElementsByClassName('foco');
            let idImagenes = [];
            for(var i = 0; i <= imagenes.length-1; i++) {
                foco[i] = imagenes[i].getAttribute('id');
            }
            addTirada(entidad, habilidad, tirada, foco);
            $('#foco').html('');
            $('#lanzarHabilidades').html(''); 
            }
        });
}

function addTirada(entidad, habilidad, tirada, foco)
{
    var parametros = {
        "entidad" : entidad,
        "habilidad" : habilidad,
        "tirada" : tirada,
        "foco" : foco,
    };
    var ruta = "{{route('tirada.addTirada', $escenario->id)}}";
    $.ajax({
        url: ruta,
        type: "GET",
        data: parametros,
        dataType: 'JSON',
        success: function (data) {
            $('#cajaComentarios').append(data);
            $("#cajaComentarios").scrollTop(30000);
        }
    });
}

        $(document).ready(function (){
            $("#cajaComentarios").scrollTop(30000);
            cargarPersonajes();
            cargarEnemigos();
            cargarJefes();
            setInterval("actualizarEntidades();", 1000);
        });
        
    </script>
@endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-primary leading-tight">
        {{ __('Tablero de aventura ') }}: {{$aventura->nombre}}
        </h2>
    </x-slot>
    <div>
            {{$msj ?? ''}}
            <div id="main" class="grid grid-cols-4 gap-1 justify-evenly mt-10"> 
                <div class="bg-secundary1 menuPj border-2 border-primary ml-5">
                    <div class="grid grid-cols-1 gap-4">
                        <div id="contenedor-img">
                            
                        </div>
                        <div  id="contenedor-habilidades" class="contenedor-habilidades text-center">
                            
                        </div>
                        <div id="foco" class="ml-5 text-primary text-center flex">
                            
                        </div>
                        <div id="lanzarHabilidades" class="mx-5 text-primary text-center">

                        </div> 
                    </div>
                </div> 
                <div id="tablero" class="col-span-2 m-auto" style="background-image:url('{{asset($escenario->imagen)}}')"></div> 
                <div class="bg-secundary1 text-primary border-2 border-primary mr-5">
                    <div class="overflow-y-auto bg-red px-4" style="height:600px" id="cajaComentarios">
                        @foreach($tiradas as $tirada)
                            {{$tirada}}
                            <br>
                            <br>
                            <hr>
                        @endforeach
                    </div> 
                </div>
            </div>       
</x-app-layout>