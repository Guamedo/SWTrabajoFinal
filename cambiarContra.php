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
                    <form id="fcontra" name="fcontra" action="" method="post" enctype="multipart/form-data">
                        <?php
                        if(isset($_GET['id'])){
                            $id = $_GET['id'];
                            echo "<input type='hidden' id='id' value='$id'>";
                        }else{
                            header("Location: layout.php");
                        }
                        echo "<input type='hidden' id='id' value=''>"
                        ?>
                        <input type='hidden' id='id' value=''>
                        <label>Introduce tu nueva contraseña</label><input type="text" id="pass1" required>
                        <label>Repite la contraseña</label><input type="text" id="pass2" required>
                        <label></label><input type="button" value="Enviar" onclick="cambiarContraseña()">
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

            function cambiarContraseña(){
                var email = $("#email");
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        var response = this.responseText;
                        $("#respuesta").html(response);
                        console.log(response);
                    }
                }
                xmlhttp.open("POST", "cambiarContraDB.php", true);
                xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                data = "pass1="+$("#pass1").val()+"&pass2="+$("#pass2").val()+"&id="+$("#id").val();
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
