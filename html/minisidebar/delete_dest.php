<?php
include '../../../db/connection.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM dest_tb WHERE id='$id'");

    header("Location: destination.php"); // replace with actual page name
}
?>