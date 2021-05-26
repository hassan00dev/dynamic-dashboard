<?php
include_once('connection/connect.php');

if (isset($_GET['id'])) {
    $dashboard_id = $_GET['id'];
} else {
    $dashboard_id = 1;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <?php include_once('include/head.php'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row mt-3">

                        <section class="col-12">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-md-3 d-flex justify-content-between">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-tachometer-alt"></i> Dashboards
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <?php
                                                $d_q = mysqli_query($conn, "SELECT * FROM dynamic_dashboards;");
                                                while ($d_r = mysqli_fetch_assoc($d_q)) {
                                                ?>
                                                    <a class="dropdown-item <?php
                                                        if($d_r['id'] == $dashboard_id){
                                                            echo 'active';
                                                        }
                                                    ?>" href="index.php?id=<?= $d_r['id'] ?>"><i class="fas fa-circle" style="color:<?= $d_r['color'] ?>"></i> <?= $d_r['name'] ?></a>
                                                <?php
                                                }
                                                ?>
                                                <a class="dropdown-item" href="createDashboard.php"><i class="fas fa-plus-circle"></i> Add Dashboard</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="edit.php?id=<?= $dashboard_id ?>"><i class="fas fa-edit text-primary"></i> Edit Dashboard</a>
                                                <?php if ($dashboard_id != 1) : ?>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="deleteDashboard('queries/deleteDashboard.php?id=<?= $dashboard_id ?>')"><i class="fas fa-trash text-danger"></i> Delete Dashboard</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM architectures WHERE dashboard_id = '$dashboard_id'  ORDER BY row_position ASC");
                                while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                    <div class="row">
                                        <?php
                                        $pattern = explode(',', $row['pattern']);
                                        $row_position = $row['row_position'];
                                        foreach ($pattern as $col_position => $col) {
                                            $col_query = mysqli_query($conn, "SELECT * FROM `columns` WHERE dashboard_id = '$dashboard_id' && row_position = '$row_position' && col_position = '$col_position';");
                                            if (mysqli_num_rows($col_query) > 0) { ?>
                                            <div class="col-md-<?= $col ?>">
                                            <?php
                                                static $component_counter = 0;
                                                while($col_record = mysqli_fetch_assoc($col_query)){
                                                    $component_id = $col_record['component_id'];
                                                    $component_query = mysqli_query($conn, "SELECT * FROM components WHERE id = '$component_id'");
                                                    $component = mysqli_fetch_assoc($component_query);
                                        ?>
                                                    <div class="card mb-1">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                <i class="<?= $component['icon'] ?> mr-1"></i>
                                                                <?= $component['title'] ?>
                                                            </h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php
                                                                include("components/".$component['file']);
                                                                $component_counter++;
                                                            ?>
                                                        </div>
                                                    </div>
                                            <?php
                                                }?>
                                                </div>
                                                <?php
                                            } else {
                                            ?>
                                                <div class="col-md-<?= $col ?>"></div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </section>

                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <!-- custom js -->
    <script>
        function deleteDashboard(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace(url);
                }
            })
        }
    </script>
</body>

</html>