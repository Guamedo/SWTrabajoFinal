<?php
    session_start();
    include 'validarSesionAnonimo.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
        <title>Preguntas</title>
        <link rel='stylesheet' type='text/css' href='estilos/style2.css' />
        <link rel='stylesheet' type="text/css" href='estilos/styleLogin.css'>
        <style>
            #formulario{
                height: 100%;
                max-height: 100%;
                text-align: left;
                padding-left: 20%;
                background-color: antiquewhite;
            }

            #like{
                width: 90%;
            }

            /* The container */
            .containerJ {
                border-radius: 10px;
                padding: 16px;
                display: block;
                position: relative;
                padding-left: 35px;
                margin-bottom: 12px;
                cursor: pointer;
                font-size: 22px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            /* Hide the browser's default checkbox */
            .containerJ input {
                position: absolute;
                opacity: 0;
            }

            /* Create a custom checkbox */
            .checkmarkJ {
                border: 2px solid black;
                position: absolute;
                top: 0;
                left: 0;
                height: 25px;
                width: 25px;
                background-color: #eee;
                margin-top: 15px;
            }

            /* On mouse-over, add a grey background color */
            .containerJ:hover input ~ .checkmarkJ {
                background-color: #ccc;
            }

            /* When the checkbox is checked, add a blue background */
            .containerJ input:checked ~ .checkmarkJ {
                background-color: #2196F3;
            }

            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmarkJ:after {
                content: "";
                position: absolute;
                display: none;
            }

            /* Show the checkmark when checked */
            .containerJ input:checked ~ .checkmarkJ:after {
                display: block;
            }

            /* Style the checkmark/indicator */
            .containerJ .checkmarkJ:after {
                left: 9px;
                top: 5px;
                width: 5px;
                height: 10px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }

            .button {
                width: 90%;
                background-color: #4CAF50; /* Green */
                border: none;
                color: white;
                padding: 16px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                -webkit-transition-duration: 0.4s; /* Safari */
                transition-duration: 0.4s;
                cursor: pointer;
            }

            .button {
                background-color: white;
                color: black;
                border: 2px solid #4CAF50;
            }

            .button:hover {
                background-color: #4CAF50;
                color: white;
            }

        </style>
    </head>
    <body>
        <div id='page-wrap'>
            <?php
            include 'menu.php';
            ?>
            <section class="main" id="formulario">
                <input type='hidden'  value=''>
                <?php
                    include 'connect.php';
                    if (!$link) {
                        die('Could not connect to MySQL: ' . mysql_error());
                    }
                    if(isset($_SESSION['preguntasRand'])){
                        $lista = $_SESSION['preguntasRand'];
                        $sql = "SELECT * FROM preguntas WHERE id NOT IN ( '" . implode($lista, "', '") . "' ) ORDER BY RAND() LIMIT 1";
                    }else{
                        $sql = "SELECT * FROM preguntas ORDER BY RAND() LIMIT 1";
                    }
                    $pregunta = mysqli_query($link, $sql);
                    if(!$pregunta){
                        die('Error: ' . mysqli_error($link));
                    }

                    $cont= mysqli_num_rows($pregunta);

                    if($cont==1){
                        $row = mysqli_fetch_array($pregunta);
                        $pregunta = $row['pregunta'];
                        if(substr($pregunta, 0, 1) != "¿"){
                            $pregunta = "¿ " . $pregunta;
                        }
                        if(substr($pregunta, -1) != "?"){
                            $pregunta = $pregunta . " ?";
                        }
                        $id = $row['id'];
                        if(!isset($_SESSION['preguntasRand'])){
                            $_SESSION['preguntasRand'] = array();
                        }
                        array_push($_SESSION['preguntasRand'], $id);
                        $respuestas = [];
                        array_push($respuestas, $row['respuesta_correcta'],
                                                $row['respuesta_incorrecta_1'],
                                                $row['respuesta_incorrecta_2'],
                                                $row['respuesta_incorrecta_3']);
                        shuffle($respuestas);
                        $like = $row['likee'];
                        $dislike = $row['dislike'];
                        echo
                            "<h2>$pregunta</h2>
                            <label>Likes: $like / Dislikes: $dislike</label>
                            <input id='id' type='hidden'  value='$id'>
                            <label class='containerJ'>$respuestas[0]
                                <input type='radio' name='respuesta' value='$respuestas[0]'>
                                <span class='checkmarkJ'></span>
                            </label>
                            <label class='containerJ'>$respuestas[1]
                                <input type='radio' name='respuesta' value='$respuestas[1]'>
                                <span class='checkmarkJ'></span>
                            </label>
                            <label class='containerJ'>$respuestas[2]
                                <input type='radio' name='respuesta' value='$respuestas[2]'>
                                <span class='checkmarkJ'></span>
                            </label>
                            <label class='containerJ'>$respuestas[3]
                                <input type='radio' name='respuesta' value='$respuestas[3]'>
                                <span class='checkmarkJ'></span>
                            </label>
                            <label id='like'></label>
                            <label><input id='sendButton' class='button' type='button' value='Enviar' onclick='comprobarRespuesta()'></label>";
                    }else{
                        echo "<h1>No hay más preguntas disponibles, vuelve al inicio para ver tus estadisticas de juego</h1>";
                    }
                    mysqli_close($link);
                ?>
            </section>
            <footer class='main' id='f1'>
                <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
                <a href='https://github.com'>Link GITHUB</a>
            </footer>
        </div>
        <script>

            function comprobarRespuesta(){
                if($('input[name=respuesta]:checked').length > 0) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4) {
                            var response = this.responseText;
                            if(response == "CORRECTO"){
                                $("#sendButton").val("Siguiente pregunta");
                                $("#sendButton").attr('onclick', 'siguientePregunta()');
                                $("#like").html("<h1>Te ha gustado la pregunta?</h1>");
                                var cosa = "<label class='containerJ'>Si <input type='radio' name='megusta' value='si'> <span class='checkmarkJ'></span> </label> <label class='containerJ'>No <input type='radio' name='megusta' value='no'><span class='checkmarkJ'></span> </label> ";
                                $("#like").append(cosa);
                                $('input[name=respuesta]').attr('disabled',true);
                                $("#formulario").css('height', '100%');
                                $('input[name=respuesta]').parent().css("background-color", "antiquewhite");
                                $('input[name=respuesta]:checked').parent().css("background-color", "#4CAF50");
                            }else if(response == "INCORRECTO"){
                                $("#sendButton").val("Volver a responder");
                                $('input[name=respuesta]').parent().css("background-color", "antiquewhite");
                                $('input[name=respuesta]:checked').parent().css("background-color", "#f44336");
                            }
                        }
                    }
                    xmlhttp.open("POST", "comprobarRespuesta.php", true);
                    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    data = "id="+$("#id").val()+"&respuesta="+$('input[name=respuesta]:checked').val();
                    xmlhttp.send(data);
                }
            }

            function siguientePregunta(){
                if($('input[name=megusta]:checked').length > 0) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4) {
                            var response = this.responseText.trim();
                            if(response == "OK"){
                                window.location.href = "jugarPreguntaAleatoria.php";
                            }else{
                                $("#like").html(response);
                            }
                        }
                    }
                    xmlhttp.open("POST", "preguntaLike.php", true);
                    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    data = "id="+$("#id").val()+"&megusta="+$('input[name=megusta]:checked').val();
                    xmlhttp.send(data);
                }else{
                    window.location.href = "jugarPreguntaAleatoria.php";
                }
            }


            $(document).ready(function () {

                //Logout button
                $("#logOut").click(function () {
                    alert("¡Gracias por tu visita!");
                    window.location.href = "decrementarContador.php";
                });

            });
        </script>
    </body>
</html>
