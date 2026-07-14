<?php
include '../../../db/connection.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM user_tb WHERE id='$id'");
    header("Location: user.php"); // replace with actual page name
}
?>
