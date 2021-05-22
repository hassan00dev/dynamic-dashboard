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
        $q = mysqli_query($conn,"SELECT * FROM columns WHERE dashboard_id = '$dashboard_id' AND row_position = '$row_position' group by col_position;");
        $index = 0;
        while($col = mysqli_fetch_assoc($q)){
            $responseData[$row_position]['pattern'] = explode(',',$row['pattern']);
            $responseData[$row_position]['cols'][$index] = $col['column'];
            $responseData[$row_position]['positions'][$index] = $col['col_position'];
            
            if(mysqli_num_rows(mysqli_query($conn,"SELECT DISTINCT vertical_col_position FROM columns WHERE dashboard_id = '$dashboard_id' AND row_position = '$row_position' AND col_position = '".$col['col_position']."';")) > 1){
                $responseData[$row_position]['componentIds'][$index] = [];
                $vcolpos = mysqli_query($conn,"SELECT * FROM columns WHERE dashboard_id = '$dashboard_id' AND row_position = '$row_position' AND col_position = '".$col['col_position']."';");
                while($rvcolpos = mysqli_fetch_assoc($vcolpos)){
                    $responseData[$row_position]['componentIds'][$index][] = $rvcolpos['component_id'];
                }
            }else{
                $responseData[$row_position]['componentIds'][$index] = $col['component_id'];
            }

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