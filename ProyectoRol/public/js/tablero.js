function cargarProta()
{
            $.ajax({
                url: "{{route('entidad.cargarProta', $aventura->id)}}",
                type: "GET",
                dataType: 'JSON',
                success: function (data) {
                    if (data != 0) {
                        var prota = "<img src={{asset("+imagen+")}} class='imgJugador mov imgP ficha' id='"+data.id+"' style='position:absolute;left:"+data.posX+"px;top:"+data.posY+"px;' onclick='almacenarMovimiento()'/>";
                        prota = prota.replace('+imagen', data.imagen);
                        prota = prota.replace('png+', 'png');
                        $('#tablero').append(prota);
                        $('.mov').draggable({
                            containment: "parent"                                
                        });
                    }      
                }
            });
}

function almacenarMovimiento()      
{
    var posX = $('.mov').css("left");
    var posY = $('.mov').css("top");
    posX = posX.substring(0, posX.length -2);
    posY = posY.substring(0, posY.length -2);
    var id = $('.mov').attr('id');
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
                var personaje = "<img src={{asset("+imagen+")}} class='imgJugador imgJ ficha' id='"+data[i].id+"' style='position:absolute;left:"+data[i].posX+"px;top:"+data[i].posY+"px;' onclick='foco(this)'/>";
                personaje = personaje.replace('+imagen', data[i].imagen);
                personaje = personaje.replace('png+', 'png');
                $('#tablero').append(personaje);
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
                    cargarTiradas();
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
                        var enemigo = "<img src={{asset("+imagen+")}} class='imgEnemigo imgE ficha' id='"+data[i].id+"' style='position:absolute;left:"+data[i].posX+"px;top:"+data[i].posY+"px;' onclick='foco(this)'/>";
                        var src = data[i].imagen;
                        src = src.replace(' ', '');
                        enemigo = enemigo.replace('+imagen', src);
                        enemigo = enemigo.replace('png+', 'png');
                        $('#tablero').append(enemigo);
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
                        var enemigo = "<img src={{asset("+imagen+")}} class='imgJefe imgE ficha' id='"+data[i].id+"' style='position:absolute;left:"+data[i].posX+"px;top:"+data[i].posY+"px;' onclick='foco(this)'/>";
                        var src = data[i].imagen;
                        src = src.replace(' ', '');
                        enemigo = enemigo.replace('+imagen', src);
                        enemigo = enemigo.replace('png+', 'png');
                        $('#tablero').append(enemigo);
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
        function lanzarHabilidad()
        {
            let imagenes = document.getElementsByClassName('foco');
            let idImagenes = [];
            for(var i = 0; i <= imagenes.length-1; i++) {
                idImagenes[i] = imagenes[i].getAttribute('id');
            }
            var indiceHabilidad = document.getElementById('habilidades').selectedIndex;
            var habilidad = document.getElementById('habilidades').options[indiceHabilidad].value;
            var prota = document.getElementsByClassName('prota');
            prota = prota[0].getAttribute('id');
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