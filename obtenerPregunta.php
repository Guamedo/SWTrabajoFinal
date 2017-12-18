<?php
    require_once('nusoap/lib/nusoap.php');
    if (isset($_POST['id'])){
        $soapclient = new nusoap_client('http://localhost/SWTrabajoFinal/ObtenerPreguntaSW.php?wsdl', true);
        $output = $soapclient->call('obtenerPregunta', array('id'=>$_POST['id']));
        echo trim($output['email']) . "#?*uyi66" . trim($output['enunciado']) . "#?*uyi66" . trim($output['correcta']) . "#?*uyi66" . trim($output['incorrecta1']) . "#?*uyi66" . trim($output['incorrecta2']) . "#?*uyi66" . trim($output['incorrecta3']) . "#?*uyi66" . trim($output['tema']) . "#?*uyi66" . trim($output['complejidad']) . "#?*uyi66" . $_POST['id'];
    }
?>
