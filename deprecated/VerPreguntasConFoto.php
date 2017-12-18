<!DOCTYPE html>
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
                <div>
                <?php
                    //$link= mysqli_connect("localhost", "root", "", "quiz");
                    include 'connect.php';

                    if (!$link) {
                        die('Could not connect to MySQL: ' . mysql_error());
                    }
                    $usuarios = mysqli_query($link, "select * from preguntas" );
                    echo '<table border=1> <tr> <th> E-MAIL </th>
                                                <th> PREGUNTA </th>
                                                <th> RESPUESTA CORRECTA </th>
                                                <th> RESPUESTA INCORRECTA 1 </th>
                                                <th> RESPUESTA INCORRECTA 2 </th>
                                                <th> RESPUESTA INCORRECTA 3 </th>
                                                <th> TEMA </th>
                                                <th> COMPLEJIDAD </th>
                                                <th> IMAGEN </th></tr>';
                    while ($row = mysqli_fetch_array( $usuarios )) {
                        echo ('<tr><td>' . $row['email'] . '</td>
                                  <td>' . $row['pregunta'] . '</td>
                                  <td>' . $row['respuesta_correcta'] . '</td>
                                  <td>' . $row['respuesta_incorrecta_1'] . '</td>
                                  <td>' . $row['respuesta_incorrecta_2'] . '</td>
                                  <td>' . $row['respuesta_incorrecta_3'] . '</td>
                                  <td>' . $row['tema'] . '</td>
                                  <td>' . $row['complejidad'] . '</td>');
                        if($row['imagen']===NULL || $row['imagen']==""){
                            echo '<td>Sin imagen</td>';
                        }
                        else {
                            echo "<td><img src=" . '"data:image/jpeg;base64,'.base64_encode( $row['imagen'] ).'" width="150" alt="imagen de la pregunta"/></td>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';
                    $usuarios->close();
                    mysqli_close($link);
                ?>
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
            });
        </script>
    </body>
</html>
