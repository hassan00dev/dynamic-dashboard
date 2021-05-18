<?php 
include_once('../connection/connect.php');

$data = $_POST['data'];
$id = $data[0]['dashboardId'];

// print_r($data);

// delete all rows
mysqli_query($conn,"DELETE FROM `architectures` WHERE dashboard_id = '$id';");

foreach($data as $row){
    
    $dashboard_id = $row['dashboardId'];
    $row_position = $row['rowPosition'];
    $cols_in_row = $row['cols'];
    $col = $row['col'];
    $col_position = $row['colPosition'];
    $component_id = $row['componentId'];
    
    if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `architectures` WHERE row_position = '$row_position' AND dashboard_id = '$dashboard_id';")) == 0){
        $rowQ = mysqli_query($conn,"INSERT INTO `architectures` (`dashboard_id`, `row_position`,`pattern`) VALUES ('$dashboard_id', '$row_position','$cols_in_row');");
    }

    mysqli_query($conn,"INSERT INTO `columns` (`column`, `component_id`, `row_position`, `col_position`, `dashboard_id`) 
        VALUES ('$col', '$component_id', '$row_position', '$col_position', '$dashboard_id');");
}