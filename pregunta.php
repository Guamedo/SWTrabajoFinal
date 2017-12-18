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
                    <h3>DATOS DE LA PREGUNTA</h3> <br>
                    <form id="fpreguntas" name="fpreguntas" action="InsertarPreguntaConFoto.php" method="post" enctype="multipart/form-data">
                        <?php
                            if(isset($_GET['email'])){
                                $email = $_GET['email'];
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
                        <label>Imagen relacionada con la pregunta:</label> <input type="file" id="imgF" name="imgF" accept="image/*">
                        <input type="button" id="borrarImagen" name="borrarImagen" disabled="true" value="Borrar la imagen">
                        <input type="submit" id="boton" value="Enviar solicitud">
                    </form>
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

                $("#borrarImagen").click(function(){
                    $("#imgF").replaceWith($("#imgF").val('').clone(true));
                    $("#questionIMG").remove();
                    $("#borrarImagen").prop("disabled", true);
                })

                $("#imgF").change(function(evt){



                    var files = evt.target.files;
                    var fr = new FileReader();
                    fr.onload = function () {
                        var filePath = fr.result;
                        var extension = filePath.substring(filePath.indexOf('/') + 1, filePath.indexOf(';')).toLowerCase();
                        if (extension == "gif" || extension == "png" || extension == "bmp" || extension == "jpeg" || extension == "jpg"){

                            if($("#questionIMG").length == 0){
                                var img = $("<img></img>").attr("id", "questionIMG").attr("name", "questionIMG").attr("height", "100px").attr("alt", "imagenFormulario");
                                $("#fpreguntas").append(img);
                            }

                            $("#questionIMG").attr("src", fr.result);
                            $("#questionIMG").css("position", "absolute");
                            $("#questionIMG").css("margin", "100px 100px 100px 200px");
                            $("#borrarImagen").prop("disabled", false);
                        }else{
                            alert("El archivo tiene que ser de imagen");
                            $("#imgF").replaceWith($("#imgF").val('').clone(true));
                        }
                    }
                    fr.readAsDataURL(files[0]);
                });

                /*$("#fpreguntas").submit(function (e) {

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
                });*/
            });
        </script>
    </body>
</html>
