<?php

include_once('../connection/connect.php');

$id = $_GET['id'];

if(mysqli_query($conn,"DELETE FROM dashboards WHERE id = '$id'")){
    header('location:../index.php');
}