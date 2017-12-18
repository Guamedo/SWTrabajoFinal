<?php

    include 'connect.php';
    if (!$link) {
        die('Could not connect to MySQL: ' . mysql_error());
    }

    $sql = 'SELECT nick, correctas, incorrectas FROM jugadores ORDER BY correctas DESC';
    $jugador = mysqli_query($link ,$sql);

    if(!$jugador){
        die('Error: ' . mysqli_error($link));
    }
    while ($row = mysqli_fetch_array($jugador)){
        echo $row['nick'].",".$row['correctas'].",".$row['incorrectas'].",";
    }
    mysqli_close($link);
?>
