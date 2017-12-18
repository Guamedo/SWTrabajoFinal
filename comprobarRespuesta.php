<?php
    session_start();
    if(isset($_POST['id']) && isset($_POST['respuesta']) && isset($_SESSION['anonimo'])){
        $player= trim($_SESSION['anonimo']);
        if($player == 0 && isset($_SESSION['jugador'])){
            $nick= trim($_SESSION['jugador']);
        }
        $id = trim($_POST['id']);
        $respuesta = trim($_POST['respuesta']);
        include 'connect.php';
        if (!$link) {
            die('Could not connect to MySQL: ' . mysql_error());
        }

        $sql = "SELECT * FROM preguntas WHERE id='$id'";

        $pregunta = mysqli_query($link ,$sql);

        if(!$pregunta){
            die('Error: ' . mysqli_error($link));
        }

        $cont= mysqli_num_rows($pregunta);
        if($player == 0){
                    $sql2="SELECT * FROM jugadores WHERE nick='$nick'";
                    $jugador=mysqli_query($link ,$sql2);
                    if (!$jugador){
                        die('Error: ' . mysqli_error($link));
                    }
                    $row2 = mysqli_fetch_array($jugador);
                    $incorrectas = $row2['incorrectas'];
                    $correctas = $row2['correctas'];
        }
        if($cont){
            $row = mysqli_fetch_array($pregunta);
            if($row['respuesta_correcta'] == $respuesta){
                echo "CORRECTO";
                if($player == 0)
                    $correctas = $correctas+1;
            }else{
                echo "INCORRECTO";
                if($player == 0)
                    $incorrectas = $incorrectas+1;
            }
        }
    }else{
        echo "NOOK";
    }

    if($player == 0){
        $sql="UPDATE jugadores SET correctas='$correctas', incorrectas='$incorrectas' WHERE nick='$nick'";
        $respuestas=mysqli_query($link ,$sql);
        if (!$respuestas){
            die('Error: ' . mysqli_error($link));
        }
    }
    mysqli_close($link);

?>
