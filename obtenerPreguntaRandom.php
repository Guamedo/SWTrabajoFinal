<?php

    include 'connect.php';
    if (!$link) {
        die('Could not connect to MySQL: ' . mysql_error());
    }

    $sql = 'SELECT * FROM preguntas ORDER BY RAND() LIMIT 1';
    $pregunta = mysqli_query($link ,$sql);

    if(!$pregunta){
        die('Error: ' . mysqli_error($link));
    }

    $cont= mysqli_num_rows($pregunta);

    ($cont==1) {
        $row = mysqli_fetch_array($pregunta);
        echo $row['pregunta'];
    }else{
        echo "NOOK";
    }
    mysqli_close($link);
?>
