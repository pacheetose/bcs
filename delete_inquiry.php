<?php
include 'connect.php';
if (isset($_GET['deletemsg'])) {
    $id = $_GET['deletemsg'];

    $sql = "delete from `inquiry` where id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        //echo " Delete Successfull";
        header('location:Inquiry.php');
    } else {
        die(mysqli_error($conn));
    }
}
