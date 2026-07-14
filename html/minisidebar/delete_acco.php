<?php
include '../../../db/connection.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($con, "DELETE FROM ac_tb WHERE a_id='$id'");
    header("Location: accomodation.php"); // replace with actual page name
}
?>