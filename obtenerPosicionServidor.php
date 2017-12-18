<?php
    $url = "http://ip-api.com/json/?callback";
    $response = file_get_contents($url);
    echo $response;
?>
