<?php
    if(!isset($_SESSION['alumno'])){
        header("Location: layout.php");
    }else{
        $alumno = $_SESSION['alumno'];
        if($alumno == 0){
            header("Location: layout.php");
        }
    }
?>
