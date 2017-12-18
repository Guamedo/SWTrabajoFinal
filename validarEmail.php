<?php

    include 'connect.php';
	if (!$link) {
        die('Could not connect to MySQL: ' . mysql_error());
	}
    $email = trim($_POST['email']);
    $usuarios = mysqli_query($link,"select * from usuarios where email='$email'");
    $cont = mysqli_num_rows($usuarios);
    if($cont==1) {
        $id = uniqid();

        try {
            $mensaje = "http://localhost/SWlabSesion/cambiarContra.php?id=$id";
            $mensaje = wordwrap($mensaje, 70, "\r\n");
            mail($email, "Recuperar contraseña", $mensaje);

            $usuarios->close();
            $idCrypt = crypt($id, '$1$rasmusle$');
            $sql="INSERT INTO passwords(id, email) VALUES ('$idCrypt', '$email')";

            if (!mysqli_query($link ,$sql)){
                die('Error: ' . mysqli_error($link));
            }
            mysqli_close($link);

            echo 'Message has been sent' . $id;
        } catch (Exception $e) {
            echo 'Message could not be sent.';
        }
    }else{
        echo "No existe ningun usuario con ese email";
    }
?>
