<?php
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        include 'connect.php';
        if (!$link) {
            die('Could not connect to MySQL: ' . mysql_error());
        }

        $sql="DELETE FROM preguntas WHERE id='$id'";

        if (!mysqli_query($link ,$sql)){
            die('Error: ' . mysqli_error($link));
        }

        mysqli_close($link);

        echo "OK";
    }else{
        echo "NOOK";
    }
?>
