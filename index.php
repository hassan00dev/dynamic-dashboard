<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Dashboard</title>
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
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit</a></li>
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
                <div class="tab-pane fade show active pt-2 connectedSortable" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  <div class="card mb-1">
                    <div class="card-header">
                      <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Sales
                      </h3>
                    </div>
                  </div>
                  <?php $i = 0;
                  while ($i++ != 35) : ?>
                    <div class="card mb-1">
                      <div class="card-header">
                        <h3 class="card-title">
                          <i class="fas fa-chart-pie mr-1"></i>
                          component
                        </h3>
                      </div>
                    </div>
                  <?php endwhile; ?>
                </div>
              </div>
            </section>

            <section class="col-lg-9">
              <div class="container-fluid" id="dashboard-container">

              </div>
              <div class="container-fluid d-flex justify-content-center mt-5">
                <button type="button" class="btn btn-primary btn-sm mx-1 btn-block" onclick="addRow()">
                  <i class="fas fa-plus"></i>
                  Add Row
                </button>
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
  <script>
    let totalRows = 0;
    init();

    function init() {
      $('.connectedSortable').sortable({
        connectWith: '.connectedSortable',
        cursor: "move",
        scroll: false,
        // handle: '.card-header, .nav-tabs',
        placeholder: 'sort-highlight',
        forcePlaceholderSize: true,
        zIndex: 999999,
        cursorAt: {
          right: 50,
          top: 3
        },
      })
      $('.connectedSortable .card-header').css('cursor', 'move');
    }

    function addRow() {
      selectColumns = `
        <div class="container-fluid">
          <div class="row col-row col-row-border" onclick="addColumnOnRow(${totalRows},[12])">
            <div class="col-md-12 col-border text-center col-text col-border-radius-start col-border-radius-end">1</div>
          </div>
          <div class="row col-row col-row-border" onclick="addColumnOnRow(${totalRows},[6,6])">
            <div class="col-md-6 col-border text-center col-text col-border-radius-start">1/2</div>
            <div class="col-md-6 col-border text-center col-text col-border-radius-end">1/2</div>
          </div>
          <div class="row col-row col-row-border" onclick="addColumnOnRow(${totalRows},[4,4,4])">
            <div class="col-md-4 col-border text-center col-text col-border-radius-start">1/3</div>
            <div class="col-md-4 col-border text-center col-text">1/3</div>
            <div class="col-md-4 col-border text-center col-text col-border-radius-end">1/3</div>
          </div>
          <div class="row col-row col-row-border" onclick="addColumnOnRow(${totalRows},[3,6,3])">
            <div class="col-md-3 col-border text-center col-text col-border-radius-start">1/4</div>
            <div class="col-md-6 col-border text-center col-text">2/4</div>
            <div class="col-md-3 col-border text-center col-text col-border-radius-end">1/4</div>
          </div>
          <div class="row col-row col-row-border" onclick="addColumnOnRow(${totalRows},[3,3,3,3])">
            <div class="col-md-3 col-border text-center col-text col-border-radius-start">1/4</div>
            <div class="col-md-3 col-border text-center col-text">1/4</div>
            <div class="col-md-3 col-border text-center col-text">1/4</div>
            <div class="col-md-3 col-border text-center col-text col-border-radius-end">1/4</div>
          </div>
          <div class="row col-row col-row-border" onclick="addColumnOnRow(${totalRows},[4,8])">
            <div class="col-md-4 col-border text-center col-text col-border-radius-start">1/3</div>
            <div class="col-md-8 col-border text-center col-text col-border-radius-end">2/3</div>
          </div>
          <div class="row col-row col-row-border" onclick="addColumnOnRow(${totalRows},[3,9])">
            <div class="col-md-3 col-border text-center col-text col-border-radius-start">1/4</div>
            <div class="col-md-9 col-border text-center col-text col-border-radius-end">3/4</div>
          </div>
          <div class="row col-row col-row-border" onclick="addColumnOnRow(${totalRows},[9,3])">
            <div class="col-md-9 col-border text-center col-text col-border-radius-start">3/4</div>
            <div class="col-md-3 col-border text-center col-text col-border-radius-end">1/4</div>
          </div>
          <div class="row col-row col-row-border" onclick="addColumnOnRow(${totalRows},[8,4])">
            <div class="col-md-8 col-border text-center col-text col-border-radius-start">2/3</div>
            <div class="col-md-4 col-border text-center col-text col-border-radius-end">1/3</div>
          </div>
        </div>`;

      $("#dashboard-container").append(`
        <div class="row px-1 row-border mb-2 p-1" id="row-${totalRows}">
          ${selectColumns}
        </div>
    `);
      totalRows++;
    }

    function addColumnOnRow(rowId, columns) {
      let cols = ``;
      columns.forEach(function(col, index) {
        cols += `<div class="connectedSortable col-md-${col}"></div>`;
      });
      let row = $(`#row-${rowId}`);
      row.html(cols);
      row.addClass('col-row-height');
      console.log(cols);
      init();
    }
  </script>
</body>

</html>