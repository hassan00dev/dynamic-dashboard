<?php
define('APP_NAME','DragDrop Application');
define('APP_URL','http://localhost/dragdrop-adminlte');

$conn = mysqli_connect('localhost','root','','drapdrop-adminlte');

if(mysqli_errno($conn) > 0){
    die('database connection not established. '.mysqli_error($conn));
}