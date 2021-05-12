<?php 
include_once('../connection/connect.php');

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

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
        $index = 0;
        while($col = mysqli_fetch_assoc($q)){
            $responseData[$row['row_position']]['cols']['index'.$index] = $col['column'];
            $responseData[$row['row_position']]['positions']['index'.$index] = $col['col_position'];
            $responseData[$row['row_position']]['componentIds']['index'.$index] = $col['component_id'];

            $index++;
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

echo json_encode($data);