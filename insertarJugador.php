<?php
    session_start();
    $jugador=trim($_POST['jugador']);

	//Comprobraciones de los datos
	if(preg_match('/^[^ ]+$/' , $jugador)!=1){
        echo 'Error: el nick debe ser una única palabra.<br>' ;
        echo 'Email: ' . $jugador;
        exit();
    }

    include 'connect.php';

	if (!$link) {
        die('Could not connect to MySQL: ' . mysql_error());
	}

    /****************************************
    * Insertar jugador en la base de datos *
    *****************************************/
    $sql = "SELECT * FROM jugadores WHERE nick='$jugador'";
    $jugadorDB = mysqli_query($link ,$sql);

    if (!$jugadorDB){
        die('Error: ' . mysqli_error($link));
    }
    if(mysqli_num_rows($jugadorDB) > 0){
        echo 'Ese nick ya esta en uso';
        mysqli_close($link);
        exit();
    }

    $jugadorDB->close();

	$sql = "INSERT INTO jugadores(nick, correctas, incorrectas) VALUES ('$jugador', '0', '0')";

    if (!mysqli_query($link ,$sql)){
        die('Error: ' . mysqli_error($link));
    }

    $_SESSION['jugador'] = $jugador;
    $_SESSION['anonimo'] = 0;

    echo("OK");
    mysqli_close($link);
?>
