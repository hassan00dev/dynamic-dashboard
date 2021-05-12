<?php 
include_once('../connection/connect.php');

$dashboard_id = $_POST['dashboardId'];

$dashboard_detail = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM `dashboards` WHERE id = '$dashboard_id'"));

function fetch_rows() {
    $conn = $GLOBALS['conn'];
    $dashboard_id = $GLOBALS['dashboard_id'];
    $responseData = [];
    $query = mysqli_query($conn,"SELECT * FROM `architectures` WHERE dashboard_id = '$dashboard_id'");
    
    while($row = mysqli_fetch_assoc($query)){
        $row_position = $row['row_position'];
        $q = mysqli_query($conn,"SELECT * FROM columns WHERE dashboard_id = '$dashboard_id' AND row_position = '$row_position';");
        while($col = mysqli_fetch_assoc($q)){
            $responseData[$row['row_position']]['cols'][] = $col['column'];
            $responseData[$row['row_position']]['positions'][] = $col['col_position'];
            $responseData[$row['row_position']]['componentIds'][] = $col['component_id'];
        }
    }

    return $responseData;
}


$data = [
    'id' => $dashboard_detail['id'],
    'name' => $dashboard_detail['name'],
    'color' => $dashboard_detail['color'],
    'rows' => fetch_rows()
];

print_r($data);