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
    <style>
        /* .add-row-height {
      height: 60px;
    } */
        .row-border {
            border: 2px dashed #007bff;
            border-radius: 5px;
        }

        .col-row-height {
            height: 60px;
        }

        .col-row {
            height: 30px;
            margin-top: 7px;
            margin-bottom: 7px;
        }

        .col-row:hover {
            background-color: #eaedf1;
        }

        .col-text {
            font-size: 20px;
        }

        .col-border {
            border: 1px solid grey;
        }

        .col-border-radius-start {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .col-border-radius-end {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .content-header {
            height: 70px;
        }

        .component-sidebar {
            height: calc(100vh - 70px);
            margin-top: -16px;
            overflow: hidden;
            overflow-y: scroll;
        }

        .nav-tabs .nav-link.active {
            background-color: #f5f5f5;
        }
    </style>
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
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
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

                        <section class="col-lg-3 component-sidebar">
                            <nav>
                                <div class="nav nav-tabs justify-content-between" id="nav-tab" role="tablist">
                                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                        <i class="fas fa-cogs"></i> Components
                                    </a>
                                    <a class="nav-link dropdown-toggle" href="javascript::void(0);" id="dropdownMenuButton" data-toggle="dropdown">
                                        <i class="fas fa-list"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active pt-2" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                </div>
                            </div>
                        </section>

                        <section class="col-lg-9">
                            <div class="container-fluid mt-5">
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM architectures WHERE dashboard_id = '$dashboard_id'  ORDER BY row_position ASC");
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <div class="row">
                                        <?php
                                        $pattern = explode(',', $row['pattern']);
                                        $row_position = $row['row_position'];
                                        foreach ($pattern as $col_position => $col) {
                                            $col_query = mysqli_query($conn, "SELECT * FROM `columns` WHERE dashboard_id = '$dashboard_id' && row_position = '$row_position' && col_position = '$col_position';");
                                            if (mysqli_num_rows($col_query) > 0) {
                                                $col_record = mysqli_fetch_array($col_query);
                                                $component_id = $col_record['component_id'];
                                                $component_query = mysqli_query($conn, "SELECT * FROM components WHERE id = '$component_id'");
                                                $component = mysqli_fetch_array($component_query);
                                        ?>
                                                <div class="col-md-<?= $col_record['column'] ?>">
                                                    <div class="card mb-1">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                <i class="<?= $component['icon'] ?> mr-1"></i>
                                                                <?= $component['title'] ?>
                                                            </h3>
                                                        </div>
                                                    </div>
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
</body>

</html>