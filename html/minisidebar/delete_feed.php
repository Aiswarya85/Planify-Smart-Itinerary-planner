<?php
include '../../../db/connection.php';
if (isset($_GET['fb_id'])) {
    $id = $_GET['fb_id'];
    mysqli_query($con, "DELETE FROM feedback_tb WHERE f_id='$id'");
    header("Location: feedback.php"); // replace with actual page name
}
?>
