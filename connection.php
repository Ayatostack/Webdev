<?php

$link = mysqli_connect("localhost", "wakuwaku", "J9Kv38dzL2", "wakuwaku_Recipe");
if(mysqli_connect_error()){
    die('ERROR: Unable to connect:' . mysqli_connect_error()); 
    echo "<script>window.alert('Hi!')</script>";
}
    ?>