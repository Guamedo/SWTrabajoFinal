<?php
    session_start();
    include 'validarSesionAnonimo.php';
    $_SESSION['anonimo'] = 1;

?>
<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
        <title>Preguntas</title>
        <link rel='stylesheet' type="text/css" href='estilos/style2.css'>
        <link rel='stylesheet' type="text/css" href='estilos/styleLogin.css'>

        <style>
            a.preg:link, a.preg:visited, a.user:link, a.user:visited, a.anonimo:link, a.anonimo:visited {
                background-color: #4CAF50;
                color: white;
                padding: 20px;
                font-size: 20px;
                font-family: sans-serif;
                cursor: pointer;
                text-decoration: none;
                border: 2px solid #4CAF50;
            }

            a.preg:hover, a.preg:active, a.user:hover, a.user:active, a.anonimo:hover, a.anonimo:active {
                border-color: #3e8e41;
                background-color: #3e8e41;
            }

            .dropbtn {
                background-color: #4CAF50;
                color: white;
                padding: 20px;
                font-size: 20px;
                cursor: pointer;
                border: 1px solid #4CAF50;
            }

            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }

            .dropdown-content a {
                color: black;
                padding: 20px 22px;
                text-decoration: none;
                display: block;
            }

            .dropdown-content a:hover {
                background-color: #f1f1f1
            }

            .dropdown:hover .dropdown-content {
                display: block;
            }

            .dropdown:hover .dropbtn {
                background-color: #3e8e41;
            }

            #form {
                background-color: rgb(49,230,140); border: 4px solid rgb(26, 16, 26); height: 120px; width: 400px;
            }

            #form label {
                float: left;
            }
            #boton {
                position: absolute;  margin: 60px 0px 0px -220px;
            }
        </style>

    </head>
    <body>
        <div class='page-wrap'>
            <?php
            include 'menu.php';
            ?>
            <section class="main" id="s1">
                <div id="focus">
                    <?php
                    if(isset($_SESSION['jugador'])){
                        $_SESSION['anonimo'] = 0;
                    ?>
                        <a class="preg" id="preg" href="jugarPreguntaAleatoria.php">Pregunta aleatoria</a>

                        <div class="dropdown" id="dropdown">
                            <button class="dropbtn">Preguntas por tema</button>
                                <div class="dropdown-content">
                                <?php
                                    include 'connect.php';

                                    if (!$link) {
                                        die('Could not connect to MySQL: ' . mysql_error());
                                    }

                                    $preguntas = mysqli_query($link, "select * from preguntas" );
                                    $temas = [];
                                    while($row = mysqli_fetch_array($preguntas)){
                                        $tema = $row['tema'];
                                        if(!in_array($tema, $temas)){
                                            array_push($temas, $tema);
                                        }
                                    }

                                    foreach($temas as $t){
                                        echo "<a href='jugarPreguntaPorTema.php?tema=$t'>$t</a>";
                                    }
                                ?>
                                </div>
                        </div>
                    <?php
                    }else{
                    ?>
                        <h1>Seleciona cómo quieres jugar</h1><br/>
                        <a class="user" id="user" href="#">Como jugador con nickname</a>
                        <a class="anonimo" id="anonimo" href="#">Como jugador anónimo</a>

                        <form id="form" name="form" action="insertarJugador.php" method="post" enctype="multipart/form-data" style="display: none;">
                            <br/>
                            <label>Inserta el nick de jugador*: </label><input id="jugador" name="jugador" type="text" required title="El nickname ha de ser tan solo una palabra." pattern="[^ ]+">
                            <input type="button" id="boton" value="Enviar solicitud" onclick="insertarJugador()"/>
                        </form>

                        <a class="preg" id="preg" href="jugarPreguntaAleatoria.php" style="display: none;">Pregunta aleatoria</a>

                        <div class="dropdown" id="dropdown" style="display: none;">
                            <button class="dropbtn">Preguntas por tema</button>
                                <div class="dropdown-content">
                                <?php
                                    include 'connect.php';

                                    if (!$link) {
                                        die('Could not connect to MySQL: ' . mysql_error());
                                    }

                                    $preguntas = mysqli_query($link, "select * from preguntas" );
                                    $temas = [];
                                    while($row = mysqli_fetch_array($preguntas)){
                                        $tema = $row['tema'];
                                        if(!in_array($tema, $temas)){
                                            array_push($temas, $tema);
                                        }
                                    }

                                    foreach($temas as $t){
                                        echo "<a href='jugarPreguntaPorTema.php?tema=$t'>$t</a>";
                                    }
                                ?>
                                </div>
                        </div>

                    <?php
                    }
                    ?>
                </div>
            </section>

            <footer class='main' id='f1'>
                <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
                <a href='https://github.com'>Link GITHUB</a>
            </footer>

        </div>

        <script>

            function obtenerPreguntaRandom(){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        var response = this.responseText;
                        $("#messageBox").html(response);
                    }
                }
                xmlhttp.open("POST", "obtenerPreguntaRandom.php", true);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xmlhttp.send(null);
            }
            function insertarJugador(){

                var phphttp = new XMLHttpRequest();
                phphttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        var response = this.responseText.trim();
                        if(response == "OK"){
                            var player = $("#jugador").val();
                            $("#form").css('display', 'none');
                            $("#preg").css('display', 'inline-block');
                            $("#dropdown").css('display', 'inline-block');
                            $('h1').text('Selecciona el modo de juego');
                        }else{
                            //$("#cosa").html(response);
                            alert(response);
                        }
                    }
                }
                phphttp.open("POST", "insertarJugador.php", true);
                phphttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                data = "jugador="+$("#jugador").val();
                phphttp.send(data);
            }

            $(document).ready(function () {
                 $("#anonimo").click(function () {
                    $("#preg").css('display', 'inline-block');
                    $("#dropdown").css('display', 'inline-block');
                    $("#user").css('display', 'none');
                    $("#anonimo").css('display', 'none');
                    $('h1').text('Selecciona el modo de juego');
                });
                $("#user").click(function () {
                    $("#user").css('display', 'none');
                    $("#anonimo").css('display', 'none');
                    $("#form").css('display', 'block');
                });
            });
        </script>
    </body>
</html>
