<?php 
include_once('../connection/connect.php');

$data = $_POST['data'];
$dashboard = $_POST['dashboard'];

$name = $dashboard['name'];
$color = $dashboard['color'];
mysqli_query($conn,"INSERT INTO `dynamic_dashboards`(`name`, `color`) VALUES ('$name','$color')");

$id = mysqli_insert_id($conn);

foreach($data as $row){

    $row_position = $row['rowPosition'];
    $cols_in_row = $row['cols'];
    $col = $row['col'];
    $col_position = $row['colPosition'];
    $component_id = $row['componentId'];

    if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `architectures` WHERE row_position = '$row_position' AND dashboard_id = '$id';")) == 0){
        $rowQ = mysqli_query($conn,"INSERT INTO `architectures` (`dashboard_id`, `row_position`,`pattern`) VALUES ('$id', '$row_position','$cols_in_row');");
    }

    if(isset($row['vColPosition'])){
        $vColPositions = $row['vColPosition'];
        $component_ids = $row['componentId'];
        foreach($vColPositions as $index => $vColPosition){
            $component_id = $row['componentId'][$index];
            mysqli_query($conn,"INSERT INTO `columns` (`column`, `component_id`, `row_position`, `col_position`, `vertical_col_position` ,`dashboard_id`) 
            VALUES ('$col', '$component_id', '$row_position', '$col_position','$vColPosition', '$id');");
        }
    }elseif($component_id != null){
        mysqli_query($conn,"INSERT INTO `columns` (`column`, `component_id`, `row_position`, `col_position`, `dashboard_id`) 
            VALUES ('$col', '$component_id', '$row_position', '$col_position', '$id');");
    }
}