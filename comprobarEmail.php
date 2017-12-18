<?php
	require_once('nusoap/lib/nusoap.php');
	if (isset($_GET['email'])){
        $soapclient = new nusoap_client('http://ehusw.es/jav/ServiciosWeb/comprobarmatricula.php?wsdl',true);
		$result = $soapclient->call('comprobar', array('x'=>$_GET['email']));
		if($result === 'SI'){
			echo 'SI';
        }else{
			echo 'NO';
        }
	}

?>
