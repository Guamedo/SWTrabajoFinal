<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
        <title>Registrar</title>
        <link rel='stylesheet' type='text/css' href='estilos/style2.css' />
        <link rel='stylesheet' type="text/css" href='estilos/styleLogin.css'>
    </head>
    <body>
        <div id='page-wrap'>
            <?php
            include 'menu.php';
            ?>
            <section class="main" id="s1">
                <?php
                if (isset($_POST['mailUs'])){
                    $email=trim($_POST['mailUs']);
                    $nombre=trim($_POST['nombre']);
                    $nick=trim($_POST['nick']);
                    $contra=crypt(trim($_POST['contra']), '$1$rasmusle$');
                    //$link = mysqli_connect("localhost", "root", "", "quiz");
                    include 'connect.php';

                    if (!$link) {
                        die('Could not connect to MySQL: ' . mysql_error());
                    }
                    $usuarios = mysqli_query($link,"select * from usuarios where email='$email'");
                    $cont= mysqli_num_rows($usuarios);
                    if($cont>=1) {
                        ?>
                        <div id="formulario-registro">
                            <form id="registro" name="registro" action="Registrar.php" method="post" enctype="multipart/form-data">
                                <label> Email*: </label> <input id="mailUs" name="mailUs" type="email" required title="Se necesita un email del formato EHU/UPV." pattern="[a-z]+[0-9]{3}@ikasle\.ehu\.(es|eus)">
                                <label> Nombre y apellidos*: </label><input id="nombre" name="nombre" type="text" required title="Se necesita un nombre y, al menos, un apellido." pattern="[a-zA-Z]+ [a-zA-Z]+( [a-zA-Z]+)*" />
                                <label> Nick*: </label> <input id="nick" name="nick" type="text" required title="El nickname ha de ser tan solo una palabra." pattern="[^ ]+">
                                <label> Password*: </label><input type="password" id="contra" name="contra" required title="La contraseña ha de tener 6 carácteres" pattern=".{6,}" />
                                <label> Repetir password*: </label><input type="password"id="contra2" name="contra2" required title="La contraseña ha de tener 6 carácteres" pattern=".{6,}" />
                                <label> Foto: </label><input type="file" id="fotoF" name="fotoF" accept="image/*"/>
                                <input type="button" id="delImagen" name="delImagen" disabled="true" value="Borrar la imagen"/>
                                <input type="submit" id="enviar" value="Enviar solicitud" />
                            </form>
                        </div>
                        <?php
                        echo("<script>alert('Ya hay un usuario registrado con ese email.');</script>");
                    }else{
                        if(isset($_FILES['fotoF']['tmp_name']) && $_FILES['fotoF']['tmp_name']!=""){
                             $foto = $link->real_escape_string(file_get_contents($_FILES['fotoF']['tmp_name']));
                        }else{
                            $foto="";
                        }
                        $sql="INSERT INTO usuarios(email, nombre, nick, password, foto) VALUES ('$email','$nombre','$nick', '$contra', '$foto')";
                        ?>
                            <img src='imagenes/bienvenido.png' alt='Bienvenido a quiz' height='100px' align='center'/>
                        <?php
                        if (!mysqli_query($link ,$sql)){
                            ?>
                            <a href="javascript:history.go(-1)">Go Back</a> <br>
                            <?php
                            die('Error: ' . mysqli_error($link));
                        }
                    }
                    mysqli_close($link);
                }else{
                ?>
                    <div id="formulario-registro">
                        <form id="registro" name="registro" action="Registrar.php" method="post" enctype="multipart/form-data">
                            <label> Email*: </label> <input id="mailUs" name="mailUs" type="email" required title="Se necesita un email del formato EHU/UPV." pattern="[a-z]+[0-9]{3}@ikasle\.ehu\.(es|eus)">
                            <label> Nombre y apellidos*: </label><input id="nombre" name="nombre" type="text" required title="Se necesita un nombre y, al menos, un apellido." pattern="[a-zA-Z]+ [a-zA-Z]+( [a-zA-Z]+)*" />
                            <label> Nick*: </label> <input id="nick" name="nick" type="text" required title="El nickname ha de ser tan solo una palabra." pattern="[^ ]+">
                            <label> Password*: </label><input type="password" id="contra" name="contra" required title="La contraseña ha de tener 6 carácteres" pattern=".{6,}" />
                            <label> Repetir password*: </label><input type="password"id="contra2" name="contra2" required title="La contraseña ha de tener 6 carácteres" pattern=".{6,}" />
                            <label> Foto: </label>
                            <label></label> <input type="file" id="fotoF" name="fotoF" accept="image/*"/>
                            <label></label> <input type="button" id="delImagen" name="delImagen" disabled="true" value="Borrar la imagen"/>
                            <input type="submit" id="enviar" value="Enviar solicitud"/>
                        </form>
						<div id="respuesta1"></div>
                        <div id="respuesta2"></div>
                    </div>
                <?php
                }
                ?>
            </section>
            <footer class='main' id='f1'>
                <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
                <a href='https://github.com'>Link GITHUB</a>
            </footer>
        </div>
        <script>
            var validEmail = false;
            var validPassword = false;
            $(document).ready(function () {
                $("#enviar").click(function(){
                    var str="";
                    var xmlhttp = new XMLHttpRequest();
					xmlhttp.open("GET", "comprobarEmail.php?email="+$("#mailUs").val(), false);
					xmlhttp.send(null);
                    var emailVIP = xmlhttp.responseText;
                    console.log(emailVIP);
                    if (emailVIP == "NO"){
                        str += "<br/>"+"Este usuario no está matriculado en la UPV/EHU" + "<br/>";
                        validEmail = false;
                    } else{
                        validEmail = true;
                    }
                    $("#respuesta1").html(str);

                    var str="";
                    xmlhttp.open("GET", "comprobarContraClient.php?contra=" +$('#contra').val(), false);
					xmlhttp.send(null);
                    var password = xmlhttp.responseText;
                    var pass = $("#contra").val();
                    var confirmPassword = $("#contra2").val();
                    if (password === "INVALIDA"){
                        str += "<br/>"+"La contraseña no es válida" + "<br/>";
                        validPassword = false;
                    }else {
                        if (pass != confirmPassword) {
                            str += "Las contraseñas no coinciden";
                            validPassword = false;
                        }
                        else {
                            validPassword = true;
                        }
                    }
                    $("#respuesta2").html(str);

                    if(validEmail && validPassword){
                        return true;
                    }else{
                        return false;
                    }
                });

                $("#delImagen").click(function(){
                    $("#fotoF").replaceWith($("#fotoF").val('').clone(true));
                    $("#usIMG").remove();
                    $("#delImagen").prop("disabled", true);
                });

                $("#fotoF").change(function(evt){
                    var files = evt.target.files;
                    var fr = new FileReader();
                    fr.onload = function () {
                        var filePath = fr.result;
                        var extension = filePath.substring(filePath.indexOf('/') + 1, filePath.indexOf(';')).toLowerCase();
                        if (extension == "gif" || extension == "png" || extension == "bmp" || extension == "jpeg" || extension == "jpg"){
                            if($("#usIMG").length == 0){
                                var img = $("<img></img>").attr("id", "usIMG").attr("name", "usIMG").attr("height", "100px").attr("alt", "imagenFormulario");
                                $("#registro").append(img);
                            }
                            $("#usIMG").attr("src", fr.result);
                            $("#usIMG").css("position", "absolute");
                            $("#usIMG").css("margin", "10px 100px 100px 200px");
                            $("#delImagen").prop("disabled", false);
                        }else{
                            alert("El archivo tiene que ser de imagen");
                            $("#fotoF").replaceWith($("#fotoF").val('').clone(true));
                        }
                    }
                    fr.readAsDataURL(files[0]);
                });
            });
        </script>
    </body>
</html>
