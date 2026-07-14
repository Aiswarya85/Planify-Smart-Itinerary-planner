<?php
session_start();
include "../Db/connection.php";
if(!isset($_SESSION['id'])) {
    header("location: reg.php");
    exit();
}

$userid= $_SESSION['id'];
$place_id = $_GET['place_id'] ?? null;
$ac_id = $_GET['ac_id'] ?? null;

$date = date("Y-m-d");


if ($place_id) {
    $query = "INSERT INTO user_plan (userid, destid,date) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iis", $userid, $place_id, $date);

    if ($stmt->execute()) {
        echo "<script>alert('Destination added to your plan successfully!');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
} 

elseif ($ac_id) {
    $query = "INSERT INTO user_plan (userid, acid,date) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iis", $userid, $ac_id, $date);

    if ($stmt->execute()) {
        echo "<script>alert('Accommodation added to your plan successfully!');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
} 

else {
    echo "Invalid request.";
}


?>