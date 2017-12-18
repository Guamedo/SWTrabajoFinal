<?php
    session_start();
    include 'validarSesionProfesor.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
        <title>Preguntas</title>
        <link rel='stylesheet' type="text/css" href='estilos/style2.css'>
        <link rel='stylesheet' type="text/css" href='estilos/styleLogin.css'>
    </head>
    <style>
        section{
            min-height: 0px;
        }
        h1{
            padding-left: 20px;
        }
        #s1{
            box-sizing: border-box;
            float:left;
            max-height: 550px;
            width: 60%;
        }
        #s2{
            border-collapse: collapse;
            box-sizing: border-box;
            float:left;
            width:35%;
        }
        #fpreguntas{
            width: 90%;
        }
        tr.pregunta:hover{
            cursor: pointer;
            opacity: 0.7;
        }
    </style>
    <body>
        <div class='page-wrap'>

            <?php
                include 'menu.php';
            ?>
            <h1>SELECCIONA UNA PREGUNTA EN LA TABLA PARA EDITARLA</h1>
            <section class="main" id="s1">
                <div id="tablaPreguntas">
                <?php
                    include 'generarTabla.php'
                ?>
                </div>
            </section>
            <section class="main" id="s2">
                <div id="formulario">
                    <h3>DATOS DE LA PREGUNTA</h3> <br>
                    <form id="fpreguntas" name="fpreguntas" action="InsertarPreguntaConFoto.php" method="post" enctype="multipart/form-data">
                        <input id='id' name='id' type='hidden'>
                        <label>E-mail*:</label> <input id='mail' name='mail' type='text' readonly>
                        <label>Enunciado de la pregunta: </label><input id="pregunta" name="pregunta" type="text">
                        <label>Respuesta correcta: </label><input id="respuestaCorrecta" name="respuestaCorrecta" type="text">
                        <label>Respuesta incorrecta 1: </label><input id="respuestaIncorrecta1" name="respuestaIncorrecta1" type="text">
                        <label>Respuesta incorrecta 2: </label><input id="respuestaIncorrecta2" name="respuestaIncorrecta2" type="text">
                        <label>Respuesta incorrecta 3: </label><input id="respuestaIncorrecta3" name="respuestaIncorrecta3" type="text">
                        <label>Complejidad de la pregunta: </label>
                        <select id="complejidad" name="complejidad">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        <label>Tema de la pregunta*:</label> <input id="tema" name="tema" type="text">
                        <label></label><input type="button" id="botonCambiar" value="Guardar Pregunta" onclick="guardarPregunta()">
                        <label></label><input type="button" id="botonBorrar" value="Borrar Pregunta" onclick="borrarPregunta()">
                    </form>
                </div>
            </section>

            <footer class='main' id='f1'>
                <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
                <a href='https://github.com'>Link GITHUB</a>
            </footer>

        </div>

        <script>
            function cargarPregunta(id){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        var response = this.responseText;
                        var elements = response.split("#?*uyi66");
                        $("#mail").val(elements[0]);
                        $("#pregunta").val(elements[1]);
                        $("#respuestaCorrecta").val(elements[2]);
                        $("#respuestaIncorrecta1").val(elements[3]);
                        $("#respuestaIncorrecta2").val(elements[4]);
                        $("#respuestaIncorrecta3").val(elements[5]);
                        $("#tema").val(elements[6]);
                        $("#complejidad").val(elements[7]);
                        $("#id").val(elements[8]);
                    }
                }
                xmlhttp.open("POST", "obtenerPregunta.php", true);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                var data = "id="+id.toString();
                xmlhttp.send(data);
            }

            function guardarPregunta(){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        var response = this.responseText;
                        if(response == "OK"){
                            cargarTabla();
                        }else{
                            alert(response);
                        }
                    }
                }
                xmlhttp.open("POST", "modificarPregunta.php", true);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                var data = "pregunta="+$("#pregunta").val()+"&respuestaCorrecta="+$("#respuestaCorrecta").val()+"&respuestaIncorrecta1="+$("#respuestaIncorrecta1").val()+"&respuestaIncorrecta2="+$("#respuestaIncorrecta2").val()+"&respuestaIncorrecta3="+$("#respuestaIncorrecta3").val()+"&tema="+$("#tema").val()+"&complejidad="+$( "#complejidad option:selected" ).text()+"&id="+$("#id").val();
                xmlhttp.send(data);
            }

            function cargarTabla(){
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        //console.log(this.responseText);
                        document.getElementById("tablaPreguntas").innerHTML = this.responseText;
                    }
                }
                xmlhttp.open("GET", "generarTabla.php", true);
                xmlhttp.send(null);
            }

            function borrarPregunta(){
                if($("#id").val() == ""){
                    alert("Selecciona alguna pregunta");
                }else{
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4) {
                            var response = this.responseText;
                            if(response == "OK"){
                                $("#mail").val(null);
                                $("#pregunta").val(null);
                                $("#respuestaCorrecta").val(null);
                                $("#respuestaIncorrecta1").val(null);
                                $("#respuestaIncorrecta2").val(null);
                                $("#respuestaIncorrecta3").val(null);
                                $("#tema").val(null);
                                $("#complejidad").val("1");
                                $("#id").val(null);
                                cargarTabla();
                            }else{
                                console.log(this.responseText);
                            }
                        }
                    }
                    xmlhttp.open("POST", "borrarPregunta.php", true);
                    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    var data = "id="+$("#id").val();
                    xmlhttp.send(data);
                }
            }

            $(document).ready(function () {
                $("#logOut").click(function () {
                    alert("¡Gracias por tu visita!");
                    window.location.href = "decrementarContador.php";
                });
            });
        </script>
    </body>
</html>
