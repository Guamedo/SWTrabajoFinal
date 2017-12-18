<?php
    include 'connect.php';
    if (!$link) {
        die('Could not connect to MySQL: ' . mysql_error());
    }
    $usuarios = mysqli_query($link, "select * from preguntas" );
    echo '<table border=1> <tr> <th> E-MAIL </th>
                                <th> PREGUNTA </th>
                                <th> RESPUESTA CORRECTA </th>
                                <th> RESPUESTAS INCORRECTAS 1
                                <th> TEMA </th>
                                <th> COMPLEJIDAD </th></tr>';

    while ($row = mysqli_fetch_array( $usuarios )) {
        echo ('<tr class="pregunta" onclick="cargarPregunta('.$row['id'].')"><td>' . $row['email'] . '</td>
                  <td>' . $row['pregunta'] . '</td>
                  <td>' . $row['respuesta_correcta'] . '</td>
                  <td>'
                    . $row['respuesta_incorrecta_1'] . '<br>'
                    . $row['respuesta_incorrecta_2'] . '<br>'
                    . $row['respuesta_incorrecta_3'] .
                 '</td>
                  <td>' . $row['tema'] . '</td>
                  <td>' . $row['complejidad'] . '</td>');
        echo '</tr>';
    }
    echo '</table>';
    $usuarios->close();
    mysqli_close($link);
?>
