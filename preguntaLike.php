<?php
if(isset($_POST['id']) && isset($_POST['megusta'])){
    $id = trim($_POST['id']);
    include 'connect.php';
    if (!$link) {
        die('Could not connect to MySQL: ' . mysql_error());
    }

    $megusta = trim($_POST['megusta']);
    if($megusta == "si"){
        $sql="UPDATE preguntas SET likee=likee+1 WHERE id='$id'";
    }else if($megusta == "no"){
        $sql="UPDATE preguntas SET dislike=dislike+1 WHERE id='$id'";
    }else{
        echo "NOOK";
        exit();
    }
    if(!mysqli_query($link, $sql)){
        die('Error: ' . mysqli_error($link));
    }
    echo "OK";
}else{
    echo "NOOK";
}
?>
