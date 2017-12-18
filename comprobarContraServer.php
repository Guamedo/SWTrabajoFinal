<?php
    require_once('nusoap/lib/nusoap.php');

    //creamos el objeto de tipo soap_server
    $ns='comprobarContraServer.php?wsdl';
    $server = new soap_server;
    $server->configureWSDL('comprobarContra',$ns);
    $server->wsdl->schemaTargetNamespace=$ns;

    //registramos la función que vamos a implementar
    $server->register('comprobarContra',
    array('contra' =>'xsd:string'),
    array('output' =>'xsd:string'),
    $ns);

    //implementamos la función
    function comprobarContra($contra){
        $fichero = file_get_contents("./contras/toppasswords.txt");
        if(strpos($fichero, $contra) === false){
            return "VALIDA";
        } else {
            return "INVALIDA";
        }
    }
    //llamamos al método service de la clase nusoap
    if (!isset($HTTP_RAW_POST_DATA)) $HTTP_RAW_POST_DATA = file_get_contents('php://input');
    $server->service($HTTP_RAW_POST_DATA);
?>
