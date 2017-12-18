<?php
    session_start();
    include 'validarSesionAlumno.php';
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
    </head>
    <body>
        <div id='page-wrap'>
            <?php
            include 'menu.php';
            ?>
            <section class="main" id="s1">
                <div id="formulario">
                    <div id = "misPreguntas"><p id = "misPreguntasP">Mis preguntas: ??/??</p></div>
                    <div id = "numUsuarios"><p id = "numUsuariosP">Numero de usuarios conectados: ??</p></div>
                    <h3>DATOS DE LA PREGUNTA</h3> <br>
                    <form id="fpreguntas" name="fpreguntas" action="InsertarPreguntaConFoto.php" method="post" enctype="multipart/form-data">
                        <?php
                            if(isset($_SESSION['email'])){
                                $email = $_SESSION['email'];
                                echo "<label>E-mail*:</label> <input id='mail' name='mail' type='text' value='$email' readonly>";
                            }else{
                                echo "<label>E-mail*:</label> <input id='mail' name='mail' type='text'>";
                            }
                        ?>
                        <label>Enunciado de la pregunta*: </label><input id="pregunta" name="pregunta" type="text">
                        <label>Respuesta correcta*: </label><input id="respuestaCorrecta" name="respuestaCorrecta" type="text">
                        <label>Respuesta incorrecta 1*: </label><input id="respuestaIncorrecta1" name="respuestaIncorrecta1" type="text">
                        <label>Respuesta incorrecta 2*: </label><input id="respuestaIncorrecta2" name="respuestaIncorrecta2" type="text">
                        <label>Respuesta incorrecta 3*: </label><input id="respuestaIncorrecta3" name="respuestaIncorrecta3" type="text">
                        <label>Complejidad de la pregunta*: </label>
                        <select id="complejidad" name="complejidad">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                        <label>Tema de la pregunta*:</label> <input id="tema" name="tema" type="text">
                        <input type="button" id="boton" value="Enviar solicitud" onclick="insertarPregunta()">
                        <input type="button" id="tableButton" value="Ver preguntas" onclick="loadTable()">
                    </form>
                    <div id="phpRespuesta"></div>
                    <div id="txtHint"></div>
                </div>
            </section>
            <footer class='main' id='f1'>
                <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
                <a href='https://github.com'>Link GITHUB</a>
            </footer>
        </div>
        <script>

            //window.onload = loadXMLtable;
            updateMyQuestions();
            updateLogedIn();

            //window.onload = updateMyQuestions;
            setInterval(updateMyQuestions, 20000);
            setInterval(updateLogedIn, 20000);

            function loadTable(){
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        //console.log(this.responseText);
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                }
                xmlhttp.open("GET", "generarTabla.php", true);
                xmlhttp.send(null);
            }

            function insertarPregunta(){
                var phphttp = new XMLHttpRequest();
                phphttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        if(document.getElementById("txtHint").innerHTML !== ""){
                            loadTable();
                        }
                        document.getElementById("phpRespuesta").innerHTML = this.responseText;
                    }
                }
                phphttp.open("POST", "InsertarPreguntaConFoto.php", true);
                phphttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                data = "mail="+$("#mail").val()+"&pregunta="+$("#pregunta").val()+"&respuestaCorrecta="+$("#respuestaCorrecta").val()+"&respuestaIncorrecta1="+$("#respuestaIncorrecta1").val()+"&respuestaIncorrecta2="+$("#respuestaIncorrecta2").val()+"&respuestaIncorrecta3="+$("#respuestaIncorrecta3").val()+"&tema="+$("#tema").val()+"&complejidad="+$( "#complejidad option:selected" ).text();
                phphttp.send(data);
            }

            function updateMyQuestions(){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        var response = this.responseText;
                        document.getElementById("misPreguntasP").innerHTML = "MisPreguntas: " + response;
                    }
                }
                xmlhttp.open("POST", "misPreguntas.php", true);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                data = "email="+$("#mail").val();
                xmlhttp.send(data);
            }

            function updateLogedIn(){
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        var personas = this.responseXML.getElementsByTagName("numeroPersonas")[0].childNodes[0].nodeValue;
                        document.getElementById("numUsuariosP").innerHTML = "Numero de usuarios conectados: " + personas.toString();
                    }
                }
                xmlhttp.open("GET", "XML/contador.xml");
                xmlhttp.send(null);
            }

            $(document).ready(function () {

                //Logout button
                $("#logOut").click(function () {
                    alert("¡Gracias por tu visita!");
                    window.location.href = "decrementarContador.php";
                });



                $("#boton").click(function (e) {
                    alert("OK");
                    var str = "";
                    if($("#mail").val() === ""){
                        str += "El email\n";
                    }
                    if($("#pregunta").val() === ""){
                        str += "La pregunta\n";
                    }
                    if($("#respuestaCorrecta").val() === ""){
                        str += "La respuesta correcta\n";
                    }
                    if($("#respuestaIncorrecta1").val() === ""){
                        str += "La respuesta incorrecta 1\n";
                    }
                    if($("#respuestaIncorrecta2").val() === ""){
                        str += "La respuesta incorrecta 2\n";
                    }
                    if($("#respuestaIncorrecta3").val() === ""){
                        str += "La respuesta incorrecta 3\n";
                    }
                    if($("#tema").val() === ""){
                        str += "El tema\n";
                    }
                    if(str !== ""){
                        alert("Faltan por rellenar los siguientes campos:\n" + str);
                        e.preventDefault();
                    }else{
                        var exp = /[a-z]+[0-9]{3}@ikasle\.ehu\.(es|eus)/g ;
                        var exp2 = /.{10,}/g ;
                        if(!exp.test($("#mail").val())){
                            alert("Correo no válido");
                            e.preventDefault();
                        }
                        else if(!exp2.test($("#pregunta").val())){
                            alert("La pregunta debe tener al menos 10 caracteres");
                            e.preventDefault();
                        }
                    }
                });
            });
        </script>
    </body>
</html>
