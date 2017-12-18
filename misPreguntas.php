<?php
if(isset($_POST['email'])){
    $email = $_POST['email'];
    $numPreguntas = 0;
    $numPreguntasEmail = 0;

    include 'connect.php';
    if (!$link) {
        die('Could not connect to MySQL: ' . mysql_error());
    }

    $preguntas = mysqli_query($link, "select * from preguntas" );
    $numPreguntas = mysqli_num_rows($preguntas);
    $preguntas->close();

    $misPreguntas = mysqli_query($link, "select * from preguntas where email='$email'" );
    $numPreguntasEmail = mysqli_num_rows($misPreguntas);
    $misPreguntas->close();

    echo (string)$numPreguntasEmail . "/" . (string)$numPreguntas;
}else{
    echo "Parametros incorrectos";
}
?>
