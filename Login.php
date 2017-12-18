<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
        <title>Login</title>
        <link rel='stylesheet' type='text/css' href='estilos/style2.css' />
        <link rel='stylesheet' type="text/css" href='estilos/styleLogin.css'>
    </head>
  <body>
      <div id='page-wrap'>
        <?php
        include 'menu.php';
        ?>
        <section class="main" id="s1">

            <div id="formulario-login">
            <?php
                if (isset($_POST['uname'])){
                    include 'connect.php';

                    if (!$link) {
                        die('Could not connect to MySQL: ' . mysql_error());
                    }

                    $email=$_POST['uname'];
                    $pass=$_POST['psw'];
                    $usuarios = mysqli_query($link,"select * from usuarios where email='$email'");
                    $cont= mysqli_num_rows($usuarios);
                    if(!isset($_SESSION['intentos'])){
                        $_SESSION['intentos'] = 0;
                    }
                    //Usuario correcto
                    if($cont==1) {
                        $row = mysqli_fetch_array($usuarios);
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
                        //Contraseña correcta
                        if(hash_equals($row['password'], crypt($pass, $row['password']))){
                            unset($_SESSION['jugador']);
                            unset($_SESSION['anonimo']);
                            $_SESSION['intentos'] = 0;
                            if(preg_match('/^[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(es|eus)$/' , $email) == 1){
                                $_SESSION['alumno'] = 1;
                                $_SESSION['email'] = $email;
                            } else {
                                $_SESSION['alumno'] = 0;
                                $_SESSION['email'] = $email;
                            }
                            //Incrementar el contador de usuarios
                            $conectados = simplexml_load_file('XML/contador.xml');
                            $conectados->numeroPersonas = (intval($conectados->numeroPersonas) + 1);
                            //echo "<script>alert($conectados->numeroPersonas)</script>";
                            $conectados->asXML('XML/contador.xml');

                            if(isset($_POST['logCheckbox'])){
                            ?>
                                <img src='imagenes/LoginCorrectoHP.png' alt='Login correcto' height='100px' align='center'/><br><br>
                                <a href='layout.php'>
                                    <img src='imagenes/volverInicioHP.png' alt='Haga clic aquí para ir a inicio' height='30px' align='center'/>
                                </a><br><br>
                                <a href='#' id='out'>
                                    <img src='imagenes/desloggearseHP.png' alt='O puede hacer clic aquí para desloggearse' height='30px' align='center'/>
                                </a>
                            <?php
                            }else{
                                echo("<h1>Login correcto</h1>");
                                echo("<a href='layout.php'>Haga clic aquí para ir a inicio.</a></br><a id='out' href='#'>O puede hacer clic aquí para desloggearse.</a>");
                            }
                            echo("<script>$(document).ready(function () { alert ('BIENVENIDO AL SISTEMA: " . $row['nick'] ."'); $('#jugar').css('display', 'none');});</script>");
                        //Contraseña incorrecta
                        }else{
                            $_SESSION['intentos'] = $_SESSION['intentos'] + 1;
                            if(isset($_POST['logCheckbox'])){
                            ?>
                                <h2><?php echo $_SESSION['intentos'] ?>/3 Intentos</h2>
                                <img src='imagenes/loginIncorrectoHP.png' alt='Login incorrecto' height='100px' align='center'/><br><br>
                                <a href='layout.php'>
                                    <img src='imagenes/volverInicioHP.png' alt='Haga clic aquí para ir a inicio' height='30px' align='center'/>
                                </a><br><br>
                            <?php
                            }else{
                                echo("<h2>".$_SESSION['intentos']."/3 Intentos</h2>");
                                echo("<h1 style='color:black;'>Parámetros de login incorrectos</h1>");
                                echo("<a href='layout.php'>Haga clic aquí para ir a inicio</a>");
                            }
                        }

                    }
                    //Login incorrecto
                    else{
                        $_SESSION['intentos'] = $_SESSION['intentos'] + 1;
                        if(isset($_POST['logCheckbox'])){
                        ?>
                            <h2><?php echo $_SESSION['intentos'] ?>/3 Intentos</h2>
                            <img src='imagenes/loginIncorrectoHP.png' alt='Login incorrecto' height='100px' align='center'/><br><br>
                            <a href='layout.php'>
                                <img src='imagenes/volverInicioHP.png' alt='Haga clic aquí para ir a inicio' height='30px' align='center'/>
                            </a><br><br>
                        <?php
                        }else{
                            echo("<h2>".$_SESSION['intentos']."/3 Intentos</h2>");
                            echo ("<h1 style='color:black;'>Parámetros de login incorrectos</h1>");
                            echo("<a href='layout.php'>Haga clic aquí para ir a inicio</a>");
                        }

                    }
                    $usuarios->close();
                    mysqli_close($link);
                }else{
                    echo "<p>Ha surgido algun problema al hacer el loggin</p><br>";
                    echo "<a href='layout.php'>Haga clic aquí para ir a inicio</a>";
                }
            ?>
            </div>
        </section>
        <footer class='main' id='f1'>
            <p><a href="http://es.wikipedia.org/wiki/Quiz" target="_blank">¿Qué es un Quiz?</a></p>
            <a href='https://github.com'>Link GITHUB</a>
        </footer>
    </div>
    <script>
        $(document).ready(function () {
            $("#logOut").click(function () {
                alert("¡Gracias por tu visita!");
                window.location.href = "decrementarContador.php";
            });
            $("#out").click(function () {
                alert("¡Gracias por tu visita!");
                window.location.href = "decrementarContador.php";
            });
        });
    </script>
</body>
</html>
