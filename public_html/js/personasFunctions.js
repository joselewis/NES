//*****************************************************************
//Inyección de eventos en el HTML
//*****************************************************************



$(function () { //para la creación de los controles
    //agrega los eventos las capas necesarias
    $("#enviar").click(function () {
        addOrUpdatePersonas(false);
    });
    //agrega los eventos las capas necesarias
    $("#cancelar").click(function () {
        cancelAction();
    });    //agrega los eventos las capas necesarias

});

//*********************************************************************
//cuando el documento esta cargado se procede a cargar la información
//*********************************************************************

$(document).ready(function () {
   // showALLPersonas(true);
    
});

//*********************************************************************
//Agregar o modificar la información
//*********************************************************************

function addOrUpdatePersonas() {
    //Se envia la información por ajax
    
    if (validar()) {
        $.ajax({
            url: '../backend/agenda/controller/personasController.php', 
            data: {
                quequiereHacerelsuaurio:            "registrarse",
                idPerspna:                                  $("#txtidPerspna").val(),
                Nombre:                                     $("#txtnombre").val(),
                Apellido1:                                   $("#txtapellido1").val(),
                Apellido2:                                   $("#txtapellido2").val(),
                Telefono:                                     $("#txttelefono").val(),
                Correo:                                        $("#txtcorreo").val(),
                Lat:                                              marker.position.lat().toFixed(6),
                Long:                                           marker.position.lng().toFixed(6),
                Local:                                          $("#txtlocal").val(),
                Direccion:                                   $("#txtdireccion").val(),
                Cedula_Juridica:                       $("#txtcedjuridica").val(),
                Provincia:                       $("#txtprovincia").val()
            },
            error: function () { //si existe un error en la respuesta del ajax
                swal("Error", "Se presento un error al enviar la informacion", "error");
            },
            success: function (data) { //si todo esta correcto en la respuesta del ajax, la respuesta queda en el data
                var messageComplete = data.trim();
                var responseText = messageComplete.substring(2);
                var typeOfMessage = messageComplete.substring(0, 2);
                if (typeOfMessage === "M~") { //si todo esta corecto
                    swal("Confirmacion", responseText, "success");
                    //clearFormPersonas();
                    //showALLPersonas();
                } else {//existe un error
                    swal("Error", responseText, "error");
                }
            },
            type: 'POST'
        });
    }else{
        swal("Error de validación", "Los datos del formulario no fueron digitados, por favor verificar", "error");
    }
}



//*****************************************************************
//*****************************************************************
function validar() {
    var validacion = true;

    
    //valida cada uno de los campos del formulario
    //Nota: Solo si fueron digitados
    if ($("#txtPK_cedula").val() === "") {
        validacion = false;
    }

    if ($("#txtnombre").val() === "") {
        validacion = false;
    }

    if ($("#txtapellido1").val() === "") {
        validacion = false;
    }

    if ($("#txtapellido2").val() === "") {
        validacion = false;
    }

    if ($("#txtfecNacimiento").val() === "") {
        validacion = false;
    }

    if ($("#txtsexo").val() === "") {
        validacion = false;
    }

    if ($("#txtobservaciones").val() === "") {
        validacion = false;
    }


    return validacion;
}

/**********************************MAPA*********************************/
//Variables globales
            var map;
            
            var location = new google.maps.LatLng(9.934720, -84.105909);
            
            mostrarMapa();

            window.onresize = function () {
                resizeMap();
            };

            //*********************************************************************
            //*********************************************************************
            //*********************************************************************
            //Funciones de los mapas
            //*********************************************************************
            //*********************************************************************
            //*********************************************************************

            function mostrarMapa() {
                var location = new google.maps.LatLng(9.934720, -84.105909);
                var zoom = 8;

                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        zoom = 16;
                    });
                } else {
                   location = new google.maps.LatLng(9.934720, -84.105909);
                    zoom = 8;
                }

                //toma la capa en donde se creara el mata
                var mapCanvas = document.getElementById('map-container');

                //setea las opciones del mapa
                var mapOptions = {
                    center: location,
                    zoom: zoom,
                    panControl: false,
                    gestureHandling: 'cooperative',
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                //crea el mapa en la capa seleccionada y con las opciones indicadas
                map = new google.maps.Map(mapCanvas, mapOptions);

                //crea un nuevo marcador y lo setea en el mapa
                marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: location
                });

                //le setea un efecto al marcados
                marker.addListener('click', toggleBounce);
                marker.addListener('drag', obtenerCoordenadas);


                //toma la latitud del marcador 
                var latLng = marker.getPosition(); // returns LatLng object

                //y setea el mapa en la latitud del marcados
                map.setCenter(latLng); // setCenter takes a LatLng object

                //informacion del marcador
                var contentString = '<div class="info-window">' +
                                        '<h3 style="text-align:center;">SELECCIONE LA UBICACIÓN</h3>' +
                                        '<div class="info-content">' +
                                        '   <p style="text-align:center;">Seleccione y arrastre el marcador en la <b>ubicación en donde se encuentra la bodega</b> en el mapa</p>' +
                                        '</div>' +
                                    '</div>';

                //crea un info window en donde se mostrara la informacion en el marcados
                var infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 400
                });

                //le pone el info window en el marcador
                infowindow.open(map, marker);

            }

            //**********************************************************************************
            //efecto del marcador al dar clic
            //**********************************************************************************

            function toggleBounce() {
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            }

            //**********************************************************************************
            //**********************************************************************************


            //**********************************************************************************
            //optiene las coordenadas del marcador en el mapa
            //**********************************************************************************
            function obtenerCoordenadas(){
                var ubicacion = marker.position.lat().toFixed(6) + "&" + marker.position.lng().toFixed(6);
                $("#coordenadas").html(ubicacion);
                
            }

            //**********************************************************************************
            //se crea el mapa 
            //**********************************************************************************
            google.maps.event.addDomListener(window, 'load', mostrarMapa);