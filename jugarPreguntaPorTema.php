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
                text-align: left;
                padding-left: 20%;
                background-color: antiquewhite;
                max-height: 100%;
                height: auto;
            }

            #pregunta, #messageBoxL{
                width: 90%;
            }

            .sep{
                width: 50%;
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
                <div>
                <input type='hidden'  value=''>
                <?php
                    include 'connect.php';
                    if (!$link) {
                        die('Could not connect to MySQL: ' . mysql_error());
                    }
                    $tema = $_GET['tema'];
                    $sql = "SELECT * FROM preguntas WHERE tema='$tema' ORDER BY RAND() LIMIT 3";
                    $preguntas = mysqli_query($link ,$sql);

                    if(!$preguntas){
                        die('Error: ' . mysqli_error($link));
                    }

                    $cont= mysqli_num_rows($preguntas);
                    $index = 1;
                    if($cont){
                        while ($row = mysqli_fetch_array($preguntas)) {
                            $pregunta = $row['pregunta'];
                            if(substr($pregunta, 0, 1) != "¿"){
                                $pregunta = "¿ " . $pregunta;
                            }
                            if(substr($pregunta, -1) != "?"){
                                $pregunta = $pregunta . " ?";
                            }
                            $id = $row['id'];
                            $respuestas = [];
                            array_push($respuestas, $row['respuesta_correcta'],
                                                    $row['respuesta_incorrecta_1'],
                                                    $row['respuesta_incorrecta_2'],
                                                    $row['respuesta_incorrecta_3']);
                            shuffle($respuestas);
                            echo
                                "<label id='pregunta'><h2>$pregunta</h2></label>
                                <input id='id$index' type='hidden'  value='$id'>
                                <label class='containerJ'>$respuestas[0]
                                    <input type='radio' name='respuesta$index' value='$respuestas[0]'>
                                    <span class='checkmarkJ'></span>
                                </label>
                                <label class='containerJ'>$respuestas[1]
                                    <input type='radio' name='respuesta$index' value='$respuestas[1]'>
                                    <span class='checkmarkJ'></span>
                                </label>
                                <label class='containerJ'>$respuestas[2]
                                    <input type='radio' name='respuesta$index' value='$respuestas[2]'>
                                    <span class='checkmarkJ'></span>
                                </label>
                                <label class='containerJ'>$respuestas[3]
                                    <input type='radio' name='respuesta$index' value='$respuestas[3]'>
                                    <span class='checkmarkJ'></span>
                                </label>";
                            if($index != $cont){
                                echo
                                    "<label class='sep'>
                                    <hr>
                                    </label>";
                            }
                            $index += 1;
                        }
                    }else{
                        echo "NOOK";
                    }
                    mysqli_close($link);
                ?>
                    <label><input id="sendButton" class="button" type="button" value="Enviar" onclick="comprobarRespuesta()"></label>
                    <label id="messageBoxL"><div id="messageBox"></div></label>
                </div>
            </section>
            <footer class='main' id='f1'>
                <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
                <a href='https://github.com'>Link GITHUB</a>
            </footer>
        </div>
        <script>

            function comprobarRespuesta(){
                var numPreguntas = $("label#pregunta").length;

                for(var i = 1; i <= numPreguntas; i++){
                    if($('input[name=respuesta'+i+']:checked').length == 0){
                        alert("Responde a todas las preguntas");
                        return;
                    }
                }

                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        var response = this.responseText;
                        var responseArray = response.split("#?*uyi66");
                        for(var i = 0; i < responseArray.length - 1; i++){
                            if(responseArray[i] == "CORRECTO"){
                                $('input[name=respuesta'+(i+1)+']').parent().css("background-color", "antiquewhite");
                                $('input[name=respuesta'+(i+1)+']:checked').parent().css("background-color", "#4CAF50");
                            }else{
                                $('input[name=respuesta'+(i+1)+']').parent().css("background-color", "antiquewhite");
                                $('input[name=respuesta'+(i+1)+']:checked').parent().css("background-color", "#f44336");
                            }
                            $('input[name=respuesta'+(i+1)+']').attr('disabled',true);
                            $("#sendButton").val("Volver a jugar");
                            $("#sendButton").attr('onclick', 'volverAJugar()')
                        }
                        var message = "<h2>La complejidad media de las preguntas es de: "+responseArray[responseArray.length - 1]+"</h2>"
                        $("#messageBox").html(message);
                        $('html, body').animate({ scrollTop: 200 }, 'fast');
                    }
                }
                xmlhttp.open("POST", "comprobarRespuestasTema.php", true);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

                data = "";
                for(var i = 1; i <= numPreguntas; i++){
                    if(i == 1){
                        data += "id"+i+"="+$("#id"+i+"").val()+"&respuesta"+i+"="+$('input[name=respuesta'+i+']:checked').val();
                    }else{
                        data += "&id"+i+"="+$("#id"+i+"").val()+"&respuesta"+i+"="+$('input[name=respuesta'+i+']:checked').val();
                    }
                }
                console.log(data);
                xmlhttp.send(data);
            }

            function volverAJugar(){
                window.location.href = "jugar.php";
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
