<?php
session_start();
if(isset($_POST['id1']) && isset($_POST['respuesta1']) && isset($_SESSION['anonimo'])){
    $complejidadSum = 0;
    $preguntasCont = 0;
    $player= trim($_SESSION['anonimo']);
    if($player == 0 && isset($_SESSION['jugador'])){
        $nick= trim($_SESSION['jugador']);
    }
    $id1 = $_POST['id1'];
    $respuesta1 = $_POST['respuesta1'];

    include 'connect.php';
    if (!$link) {
        die('Could not connect to MySQL: ' . mysql_error());
    }

    $sql = "SELECT * FROM preguntas WHERE id='$id1'";

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
        $complejidadSum = $complejidadSum + $row['complejidad'];
        $preguntasCont = $preguntasCont + 1;
        if($row['respuesta_correcta'] == $respuesta1){
            $corecto1 = "CORRECTO";
            if($player == 0)
                    $correctas = $correctas+1;
        }else{
            $corecto1 = "INCORRECTO";
            if($player == 0)
                    $incorrectas = $incorrectas+1;
        }
    }
    $pregunta->close();

    if(isset($_POST['id2']) && isset($_POST['respuesta2']) && isset($_SESSION['anonimo'])){

        $id2 = $_POST['id2'];
        $respuesta2 = $_POST['respuesta2'];

        $sql = "SELECT * FROM preguntas WHERE id='$id2'";

        $pregunta = mysqli_query($link ,$sql);

        if(!$pregunta){
            die('Error: ' . mysqli_error($link));
        }

        $cont= mysqli_num_rows($pregunta);
        if($cont){
            $row = mysqli_fetch_array($pregunta);
            $complejidadSum = $complejidadSum + $row['complejidad'];
            $preguntasCont = $preguntasCont + 1;
            if($row['respuesta_correcta'] == $respuesta2){
                $corecto2 = "CORRECTO";
                if($player == 0)
                    $correctas = $correctas+1;
            }else{
                $corecto2 = "INCORRECTO";
                if($player == 0)
                    $incorrectas = $incorrectas+1;
            }
        }
        $pregunta->close();

        if(isset($_POST['id3']) && isset($_POST['respuesta3']) && isset($_SESSION['anonimo'])){

            $id3 = $_POST['id3'];
            $respuesta3 = $_POST['respuesta3'];

            $sql = "SELECT * FROM preguntas WHERE id='$id3'";

            $pregunta = mysqli_query($link ,$sql);

            if(!$pregunta){
                die('Error: ' . mysqli_error($link));
            }

            $cont= mysqli_num_rows($pregunta);
            if($cont){
                $row = mysqli_fetch_array($pregunta);
                $complejidadSum = $complejidadSum + $row['complejidad'];
                $preguntasCont = $preguntasCont + 1;
                if($row['respuesta_correcta'] == $respuesta3){
                    $corecto3 = "CORRECTO";
                    if($player == 0)
                        $correctas = $correctas+1;
                }else{
                    $corecto3 = "INCORRECTO";
                    if($player == 0)
                        $incorrectas = $incorrectas+1;
                }
            }
            $pregunta->close();

            echo $corecto1 . "#?*uyi66" . $corecto2 . "#?*uyi66" . $corecto3;
        }else{
            echo $corecto1 . "#?*uyi66" . $corecto2;
        }
    }else{
        echo $corecto1;
    }
    $media = floatval(trim($complejidadSum))/floatval(trim($preguntasCont));
    echo  "#?*uyi66" . strval($media);

    if($player == 0){
        $sql="UPDATE jugadores SET correctas='$correctas', incorrectas='$incorrectas' WHERE nick='$nick'";
        $respuestas=mysqli_query($link ,$sql);
        if (!$respuestas){
            die('Error: ' . mysqli_error($link));
        }
    }
    mysqli_close($link);
}else{
    echo "Algo va regular";
}

?>
