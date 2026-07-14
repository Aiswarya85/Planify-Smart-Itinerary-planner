<?php
    $name="localhost";
    $user="root";
    $pass="";
    $db="planify_db";
    $con=new mysqli($name, $user, $pass, $db);
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>

