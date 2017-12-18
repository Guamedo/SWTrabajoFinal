<?php
    if(!isset($_SESSION['alumno'])){
        header("Location: layout.php");
    }else{
        $alumno = $_SESSION['alumno'];
        if($alumno == 1){
            header("Location: layout.php");
        }
    }
?>
