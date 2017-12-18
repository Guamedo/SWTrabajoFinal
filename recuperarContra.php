<?php
    session_start();
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
            #formulario{
                width: 100%;
                height: 100%;
                min-height: 200px;
            }
        </style>
    </head>
    <body>
        <div class='page-wrap'>
            <?php
            include 'menu.php';
            ?>
            <section class="main" id="s1">
                <div id="formulario">
                    <form id="fcontraseña" name="fcontraseña" action="" method="post" enctype="multipart/form-data">
                        <label>Introduce tu email</label><input type="text" id="email">
                        <input type="button" value="Enviar" onclick="comprobarEmail()">
                    </form>
                    <div id="respuesta">
                    </div>
                </div>

            </section>

            <footer class='main' id='f1'>
                <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
                <a href='https://github.com'>Link GITHUB</a>
            </footer>

        </div>

        <script>

            function comprobarEmail(){
                var email = $("#email");
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        var response = this.responseText;
                        $("#respuesta").html(response);
                    }
                }
                xmlhttp.open("POST", "validarEmail.php", true);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                data = "email="+$("#email").val();
                xmlhttp.send(data);
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
