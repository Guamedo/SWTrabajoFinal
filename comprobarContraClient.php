<?php
    require_once('nusoap/lib/nusoap.php');
	if (isset($_GET['contra'])){
        $soapclient = new nusoap_client('http://localhost/SWTrabajoFinal/comprobarContraServer.php?wsdl', true);
		$result = $soapclient->call('comprobarContra', array('contra'=>$_GET['contra']));
		if($result == "VALIDA"){
			echo "VALIDA";
        }
		else if($result == "INVALIDA"){
            echo "INVALIDA";
        }
        else {
            echo "UPSI UPS";
        }
	}
?>
