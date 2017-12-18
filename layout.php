<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
        <title>Preguntas</title>
        <link rel='stylesheet' type="text/css" href='estilos/style2.css'>
        <link rel='stylesheet' type="text/css" href='estilos/styleLogin.css'>
    </head>
    <body>
        <div class='page-wrap'>
            <?php
            include 'menu.php';
            ?>
            <section class="main" id="s1">
                <div id="focus">
                    Hola, soy el inicio, ¿qué tal? <br>
                    ¿Quieres pasarlo chupi haciendo unos teses?<br/><br/>
                    <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
                    <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
                </div>

            </section>

            <footer class='main' id='f1'>
                <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
                <a href='https://github.com'>Link GITHUB</a>
            </footer>

        </div>

        <script>
            var input ="";
            var input2 ="";
            function obtenerJugadores(){
                var phphttp = new XMLHttpRequest();
                phphttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        if(this.responseText.trim() != ""){
                            input = this.responseText.trim();
                            google.charts.load('current', {'packages':['bar']});
                            google.charts.setOnLoadCallback(drawChart);
                        }
                    }
                }
                phphttp.open("GET", "obtenerJugadores.php", true);
                phphttp.send(null);
            }
            function obtenerJugador(){
                var phphttp = new XMLHttpRequest();
                phphttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        if (this.responseText.trim() != "NO HAY"){
                            input2=this.responseText.trim();
                            google.charts.load("current", {packages:["corechart"]});
                            google.charts.setOnLoadCallback(drawChart2);
                        }

                    }
                }
                phphttp.open("GET", "obtenerJugadorNombre.php", true);
                phphttp.send(null);
            }


            function drawChart2() {
                var data1= input2.split(",");
                var data= google.visualization.arrayToDataTable([
                      ['Tipo','Aciertos/fallos'],
                      ['Incorrectas', parseInt(data1[2])],
                      ['Correctas', parseInt(data1[1])]
                ]);

                var options = {
                  title: 'Tus respuestas',
                  is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                chart.draw(data, options);
            }

            function drawChart() {
                var data1= input.split(",");
                dataArray = [];
                dataArray.push(['Jugador', 'Correctas', 'Incorrectas']);
                /*data = google.visualization.arrayToDataTable([
                      ['Jugador', 'Correctas', 'Incorrectas'],
                ]);*/
                var i=0;
                while(i<10){
                    if(typeof data1[3*i] != "undefined" && typeof data1[3*i+1] != "undefined" && typeof data1[3*i+2] != "undefined"){
                        /*data.addRows([
                          [data1[3*i], parseInt(data1[3*i+1]), parseInt(data1[3*i+2])]
                        ]);*/
                        dataArray.push([data1[3*i], parseInt(data1[3*i+1]), parseInt(data1[3*i+2])]);
                    }
                    i=i+1;
                }
                var data = google.visualization.arrayToDataTable(dataArray);
                var options = {
                  chart: {
                    title: 'Top 10 players'
                  }
                };

                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
                $(document).ready(function () {
                obtenerJugadores();
                obtenerJugador();
                $("#logOut").click(function () {
                    alert("¡Gracias por tu visita!");
                    window.location.href = "decrementarContador.php";
                });
            });
        </script>
    </body>
</html>
