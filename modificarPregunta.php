<?php
    include 'connect.php';
	if (!$link) {
        die('Could not connect to MySQL: ' . mysql_error());
	}

	$pregunta = trim($_POST['pregunta']);
	$correcta = trim($_POST['respuestaCorrecta']);
	$incorrecta1 = trim($_POST['respuestaIncorrecta1']);
	$incorrecta2 = trim($_POST['respuestaIncorrecta2']);
	$incorrecta3 = trim($_POST['respuestaIncorrecta3']);
	$tema = trim($_POST['tema']);
	$complejidad = trim($_POST['complejidad']);
    $id = trim($_POST['id']);

    //Comprobraciones de los datos
    if(strlen($pregunta)<10){
        echo 'Error: la pregunta debe tener al menos 10 caracteres';
        exit();
    }
    if(strlen($correcta)==0){
        echo 'Error: debe especificarse una respuesta correcta';
        exit();
    }
    if(strlen($incorrecta1)==0 || strlen($incorrecta2)==0 || strlen($incorrecta3)==0){
        echo 'Error: se deben especificar 3 respuestas incorrectas';
        exit();
    }
	if(strlen($tema)==0){
        echo 'Error: se debe especificar un tema';
        exit();
    }
    if($complejidad>5 ||$complejidad<1){
        echo 'Error: la complejidad ha de ser un valor entre 1 y 5';
        exit();
    }

	$sql="UPDATE preguntas
          SET
		  pregunta='$pregunta',
		  respuesta_correcta='$correcta',
		  respuesta_incorrecta_1='$incorrecta1',
		  respuesta_incorrecta_2='$incorrecta2',
		  respuesta_incorrecta_3='$incorrecta3',
		  tema='$tema',
		  complejidad='$complejidad'
          WHERE
		  id=$id";

    if (!mysqli_query($link ,$sql)){
        die('Error: ' . mysqli_error($link));
    }
    mysqli_close($link);

    echo "OK";

?>
