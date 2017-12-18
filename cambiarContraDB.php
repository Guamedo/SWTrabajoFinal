<?php
require_once('nusoap/lib/nusoap.php');

if(isset($_POST['pass1']) && isset($_POST['pass2']) && isset($_POST['id'])){

    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $id = $_POST['id'];
    if($pass1 == $pass2){
        $soapclient = new nusoap_client('http://localhost/SWTrabajoFinal/comprobarContraServer.php?wsdl', true);
        $result = $soapclient->call('comprobarContra', array('contra'=>$pass1));

        if($result == "VALIDA"){

            include 'connect.php';
            if (!$link) {
                die('Could not connect to MySQL: ' . mysql_error());
            }
            $passwords = mysqli_query($link,"select * from passwords");

            if(!function_exists('hash_equals')) {
                function hash_equals($str1, $str2) {
                    if(strlen($str1) != strlen($str2)) {
                        return false;
                    } else {
                        $res = $str1 ^ $str2;
                        $ret = 0;
                        for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
                        return !$ret;
                    }
                }
            }
            $esta = false;
            while ($row = mysqli_fetch_array( $passwords )) {
                if(hash_equals($row['id'], crypt($id, $row['id']))){
                    $esta = true;
                    $email = $row['email'];
                }
            }
            $passwords->close();
            if($esta){

                $pass1Crypt = crypt($pass1, '$1$rasmusle$');
                $sql="UPDATE usuarios
                      SET
                      password='$pass1Crypt'
                      WHERE
                      email='$email'";

                if (!mysqli_query($link ,$sql)){
                    die('Error: ' . mysqli_error($link));
                }
                mysqli_close($link);
                echo 'Se ha restablecido la contraseña';

            }else{
                echo "No hay ninguna peticion de cambio de contraseña con ese id";
            }

        }else if($result == "INVALIDA"){
            echo "La contraseña intoducida no es valida";
        }else{
            echo "Ha habido un error en la validacion de la contraseña";
        }
    }else{
        echo "Las contraseñas no coinciden";
    }
}else{
    echo "Falta alguno de los campos";
}
?>
