<?php
    session_start();
    if(isset($_SESSION['jugador'])){
        $jugador=$_SESSION['jugador'];
        include 'connect.php';
        if (!$link) {
            die('Could not connect to MySQL: ' . mysql_error());
        }

        $sql = "SELECT nick, correctas, incorrectas FROM jugadores where nick='$jugador'";
        $jugador = mysqli_query($link ,$sql);

        if(!$jugador){
            die('Error: ' . mysqli_error($link));
        }
        $row = mysqli_fetch_array($jugador);
        echo $row['nick'].",".$row['correctas'].",".$row['incorrectas'].",";

        mysqli_close($link);

    }
    else echo("NO HAY");

?>
