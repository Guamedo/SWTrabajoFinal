<?php
    session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAub70xGsjvGIDlAgwE2WsTqMHno72QB3E"></script>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Créditos</title>
    <link rel="stylesheet" type="text/css" href="estilos/style2.css">
    <link rel='stylesheet' type="text/css" href='estilos/styleLogin.css'>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
          margin-left: 40%;
          margin-top: 10px;
          height: 300px;
          width: 300px;
      }
    </style>
</head>
<body>
    <div id='page-wrap'>
        <?php
        include 'menu.php';
        ?>
        <section class="main" id="s1">
            <div>
                Eneritz Domínguez, Computación<br>
                Gonzalo Piérola, Konputazioa <br>
                <img alt="Panda Rojo" src="imagenes/panda.gif" height="300px" id="panda"><br><br>
                <button onclick="initMap()">Mi posicion</button>
                <button onclick="serverInfo()">La posicion del servidor</button>
                <div id="map"></div>
            </div>
        </section>

        <footer class='main' id='f1'>
            <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
            <a href='https://github.com'>Link GITHUB</a>
        </footer>
    </div>
	<script>
        $(document).ready(function () {
                $("#logOut").click(function () {
                    alert("¡Gracias por tu visita!");
                    window.location.href = "decrementarContador.php";
                });
        });

        // Note: This example requires that you consent to location sharing when
        // prompted by your browser. If you see the error "The Geolocation service
        // failed.", it means you probably did not give permission for the browser to
        // locate you.
        function serverInfo(){
            var phphttp = new XMLHttpRequest();
            phphttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    var response = $.parseJSON(this.responseText);
                    initMapServer(response.lat, response.lon)
                }
            }
            phphttp.open("POST", "obtenerPosicionServidor.php", true);
            phphttp.send(null);
        }

        function initMapServer(lat, lon){
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 6
            });
            var infoWindow = new google.maps.InfoWindow({map: map});

            var pos = {lat: lat, lng: lon};

            infoWindow.setPosition(pos);
            infoWindow.setContent('El servidor está aquí');
            map.setCenter(pos);
        }

        function initMap(){
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 6
            });
            var infoWindow = new google.maps.InfoWindow({map: map});

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent('Usted está aquí');
                    map.setCenter(pos);
                }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
                });
            }else{
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                                  'Error: The Geolocation service failed.' :
                                  'Error: Your browser doesn\'t support geolocation.');
        }

    </script>
</body>
</html>
