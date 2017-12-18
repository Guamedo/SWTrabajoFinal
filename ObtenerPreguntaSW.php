<?php
	//incluimos la clase nusoap.php
	require_once('nusoap/lib/nusoap.php');

	//creamos el objeto de tipo soap_server
	$ns='ObtenerPreguntaSW.php?wsdl';
	$server = new soap_server;
	$server->configureWSDL('obtenerPregunta',$ns);
	$server->wsdl->schemaTargetNamespace=$ns;

    // Parametros de Salida
    $server->wsdl->addComplexType('output',
                                  'complexType',
                                  'struct',
                                  'all',
                                  '',
                                  array('email'         => array('name' => 'enunciado','type' => 'xsd:string'),
                                        'enunciado'     => array('name' => 'enunciado','type' => 'xsd:string'),
                                        'correcta'      => array('name' => 'correcta','type' => 'xsd:string'),
                                        'complejidad'   => array('name' => 'complejidad','type' => 'xsd:int'),
                                        'incorrecta1'   => array('name' => 'enunciado','type' => 'xsd:string'),
                                        'incorrecta2'   => array('name' => 'enunciado','type' => 'xsd:string'),
                                        'incorrecta3'   => array('name' => 'enunciado','type' => 'xsd:string'),
                                        'tema'   => array('name' => 'enunciado','type' => 'xsd:string'),
                                        'existe'        => array('name' => 'existe','type' => 'xsd:int') //para ver si la pregunta existe o no
                                       )
    );
	//registramos la función que vamos a implementar
	$server->register('obtenerPregunta',
	array('id'=>'xsd:int'),
	array('return' => 'tns:output'),
	$ns);

	//implementamos la función
	function obtenerPregunta ($id){
        $result['enunciado'] = "";
		$result['correcta'] = "";
        $result['email'] = "";
        $result['incorrecta1'] = "";
        $result['incorrecta2'] = "";
        $result['incorrecta3'] = "";
        $result['tema'] = "";
		$result['complejidad'] = 0;
        $result['existe'] = 0;

		include 'connect.php';

		if (!$link) {
			die('Could not connect to MySQL: ' . mysql_error());
		}
		$usuarios = mysqli_query($link, "SELECT * FROM preguntas WHERE id='$id' LIMIT 1");
		if(mysqli_num_rows($usuarios)>0){
			while ($row = mysqli_fetch_array($usuarios)) {
				$result['enunciado'] = $row['pregunta'];
                $result['correcta'] = $row['respuesta_correcta'];
                $result['complejidad'] = $row['complejidad'];
                $result['email'] = $row['email'];
                $result['incorrecta1'] = $row['respuesta_incorrecta_1'];
                $result['incorrecta2'] = $row['respuesta_incorrecta_2'];
                $result['incorrecta3'] = $row['respuesta_incorrecta_3'];
                $result['tema'] = $row['tema'];
                $result['existe'] = 1;
			}
		}
		$usuarios->close();
		mysqli_close($link);

        return $result;
	}
	//llamamos al método service de la clase nusoap
	if (!isset( $HTTP_RAW_POST_DATA)) $HTTP_RAW_POST_DATA = file_get_contents('php://input');
	$server->service($HTTP_RAW_POST_DATA);
?>
