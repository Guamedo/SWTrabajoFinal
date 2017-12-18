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
                <div id="formulario-datos">
                    <form id="fdatos" name="fdatos" action="#" method="post" enctype="multipart/form-data">
                        <h2>Introduce el email de un usuario para obtener sus datos</h2>
                        <label> Email*: </label> <input id="mailUs" name="mailUs" type="email" required title="Se necesita un email del formato EHU/UPV." pattern="[a-z]+[0-9]{3}@ikasle\.ehu\.(es|eus)">
                        <label> Nombre: </label> <input id="nombre" name="nombre" type="text" readonly>
                        <label> Primer Apellido: </label> <input id="apellido1" name="apellido1" type="text" readonly>
                        <label> Segundo apellido: </label> <input id="apellido2" name="apellido2" type="text" readonly>
                        <label> Telefono: </label> <input id="telefono" name="telefono" type="text" readonly>
                        <input type="submit" id="send" value="Buscar usuario" />
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

                $("#fdatos").submit(function (e) {
                    e.preventDefault();
                    $.get('XML/usuarios.xml', function(d){
                        var esta = false;
                        var usuarios = $(d).find('usuario');
                        for(var i = 0; i < usuarios.length; i++){
                            var mail = $(usuarios.get(i)).find('email').text();
                            if(mail === $('#mailUs').val()){
                                $("#nombre").val($(usuarios.get(i)).find('nombre').text());
                                $("#apellido1").val($(usuarios.get(i)).find('apellido1').text());
                                $("#apellido2").val($(usuarios.get(i)).find('apellido2').text());
                                $("#telefono").val($(usuarios.get(i)).find('telefono').text());
                                esta = true;
                            }
                        }
                        if(!esta){
                            alert("Este usuario no esta en la base de datos");
                            $("#nombre").val("");
                            $("#apellido1").val("");
                            $("#apellido2").val("");
                            $("#telefono").val("");
                        }
                    });
                });
            });
        </script>
    </body>
</html>
