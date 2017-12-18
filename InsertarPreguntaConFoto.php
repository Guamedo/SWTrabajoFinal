<?php
	$email=trim($_POST['mail']);
	$pregunta=trim($_POST['pregunta']);
	$correcta=trim($_POST['respuestaCorrecta']);
	$incorrecta1=trim($_POST['respuestaIncorrecta1']);
	$incorrecta2=trim($_POST['respuestaIncorrecta2']);
	$incorrecta3=trim($_POST['respuestaIncorrecta3']);
	$tema=trim($_POST['tema']);
	$complejidad=trim($_POST['complejidad']);

	//Comprobraciones de los datos
	if(preg_match('/^[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(es|eus)$/' , $email)!=1){
        echo 'Error: el email debe ser del formato pepito123@ikasle.ehu.es.<br>' ;
        echo 'Email: ' . $email;
        //echo '<a href="javascript:history.go(-1)">Go Back</a> </br>';
        exit();
    }
    if(strlen($pregunta)<10){
        echo 'Error: la pregunta debe tener al menos 10 caracteres.<br>' ;
        //echo '<a href="javascript:history.go(-1)">Go Back</a> </br>';
        exit();
    }
    if(strlen($correcta)==0){
        echo 'Error: debe especificarse una respuesta correcta.<br>' ;
        //echo '<a href="javascript:history.go(-1)">Go Back</a> </br>';
        exit();
    }
    if(strlen($incorrecta1)==0 || strlen($incorrecta2)==0 || strlen($incorrecta3)==0){
        echo 'Error: se deben especificar 3 respuestas incorrectas.<br>' ;
        //echo '<a href="javascript:history.go(-1)">Go Back</a> </br>';
        exit();
    }
	if(strlen($tema)==0){
        echo 'Error: se debe especificar un tema.<br>' ;
        //echo '<a href="javascript:history.go(-1)">Go Back</a> </br>';
        exit();
    }
    if($complejidad>5 ||$complejidad<1){
        echo 'Error: la complejidad ha de ser un valor entre 1 y 5.<br>' ;
        //echo '<a href="javascript:history.go(-1)">Go Back</a> </br>';
        exit();
    }
	//$link = mysqli_connect("localhost", "root", "", "quiz");
    include 'connect.php';

	if (!$link) {
        die('Could not connect to MySQL: ' . mysql_error());
	}

	if(isset($_FILES['imgF']['tmp_name']) && $_FILES['imgF']['tmp_name']!=""){
        $foto = $link->real_escape_string(file_get_contents($_FILES['imgF']['tmp_name']));
	}
	else{
		$foto="";
	}

    /****************************************
    * Insertar pregunta en la base de datos *
    *****************************************/

	$sql="INSERT INTO preguntas(email,
		  pregunta,
		  respuesta_correcta,
		  respuesta_incorrecta_1,
		  respuesta_incorrecta_2,
		  respuesta_incorrecta_3,
		  tema,
		  complejidad,
		  imagen) VALUES
		  ('$email',
		  '$pregunta',
		  '$correcta',
		  '$incorrecta1',
		  '$incorrecta2',
		  '$incorrecta3',
		  '$tema',
		  '$complejidad',
		  '$foto')";


    if (!mysqli_query($link ,$sql)){
        die('Error: ' . mysqli_error($link));
    }

    //echo "Ya tenemos un nuevo test chupi guay";
    //echo "<p> <a href='VerPreguntasConFoto.php?op=preguntas&email=$email'> Ver preguntas </a>";
    mysqli_close($link);
?>
