<?php
define('APP_NAME','DragDrop Application');
define('APP_URL','http://localhost/dynamic-dashboard');

$conn = mysqli_connect('localhost','root','','dynamic_dashboard');

if(mysqli_errno($conn) > 0){
    die('database connection not established. '.mysqli_error($conn));
}