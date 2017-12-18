<?php
    session_start();
    unset($_SESSION['email']);
    unset($_SESSION['alumno']);
    session_destroy();

    //Decrementar el contador de usuarios
    $conectados = simplexml_load_file('XML/contador.xml');

    $conectados->numeroPersonas = (intval($conectados->numeroPersonas) - 1);
    $conectados->asXML('XML/contador.xml');
    echo "<script>location.href='layout.php';</script>"
    //header("Location: layout.php", true, 301);
?>
