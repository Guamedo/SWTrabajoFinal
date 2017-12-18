<?php
    require_once('nusoap/lib/nusoap.php');

    if (isset($_GET['id'])){
        $soapclient = new nusoap_client('http://localhost/SWTrabajoFinal/ObtenerPreguntaSW.php?wsdl', true);
        $output = $soapclient->call('obtenerPregunta', array('id'=>$_GET['id']));
        echo '<br/><br/>';
        if($output['existe']==0){
            echo ('No existe pregunta con esa ID en la base de datos.');
            echo '<br/><br/>';
        }
		echo('<table id="pregunta" align="center">
		   <tr> <th>Pregunta</th><th>Respuesta correcta</th><th>Complejidad</th> </tr>');
		echo('<tr> <td>' . $output['enunciado'] . '</td> <td>' . $output['correcta'] . '</td> <td>' . $output['complejidad'] . '</td></tr> </table>');
    }
?>
