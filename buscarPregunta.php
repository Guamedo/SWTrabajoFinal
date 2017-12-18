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
                    <h3>DATOS DE LA PREGUNTA</h3> <br>
                    <form id="fpreguntas" name="fpreguntas" action="buscarPregunta.php" method="post" enctype="multipart/form-data">
                        <label>Introduce el id de la pregunta que deseas buscar*: </label><input id="pregunta" name="pregunta" type="number" min="1" step="1">
                        <input type="button" id="boton" value="Enviar solicitud">
                    </form>
                    <div id="respuesta1"></div>
                </div>
            </section>
            <footer class='main' id='f1'>
                <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
                <a href='https://github.com'>Link GITHUB</a>
            </footer>
        </div>
        <script>
            $(document).ready(function () {
                $("#boton").click(function () {
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 ) {
							var respuesta = this.responseText.trim();
							$("#respuesta1").html(respuesta);
						}
					}
					xmlhttp.open("GET", "ObtenerPreguntaClient.php?id="+$("#pregunta").val(), true);
					xmlhttp.send("");
                });
            });
        </script>
    </body>
</html>
