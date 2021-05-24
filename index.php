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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.2.1/chart.min.js" integrity="sha512-tOcHADT+YGCQqH7YO99uJdko6L8Qk5oudLN6sCeI4BQnpENq6riR6x9Im+SGzhXpgooKBRkPsget4EOoH5jNCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- custom css -->
    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <div class="spinner-border" role="status"></div>
        </div>

        <!-- Content Wrapper. Contains page content -->
        <div class="w-100">
            <!-- Content Header (Page header) -->
            <div class="content-header bg-dark">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row mt-3">

                        <section class="col-12">
                            <div class="container-fluid">
                                <div class="row mb-2">
                                    <div class="col-md-3 d-flex justify-content-between">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- JQuery punch (finger) touch for mobiles -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw==" crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- custom js -->
    <script>
        function deleteDashboard(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
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