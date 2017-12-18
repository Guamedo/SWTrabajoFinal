<?php
    $conexionMode = 0;

    if($conexionMode == 0){
        $host = "localhost";
        $user = "root";
        $password = "";
        $name = "quiz";
    }else{
        $host = "localhost";
        $user = "id2943923_nely";
        $password = "******";
        $name = "id2943923_quiz";
    }
	$link = mysqli_connect($host, $user, $password, $name);
?>
