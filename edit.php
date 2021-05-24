<?php
include_once('connection/connect.php');
$query = mysqli_query($conn,"SELECT * FROM components");

if (isset($_GET['id'])) {
  $dashboard_id = $_GET['id'];
} else {
  header('location:index.php');
}

$dashboard_detail = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM dynamic_dashboards WHERE id = '$dashboard_id';"));

?>
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
  <!-- sweetalert2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- custom css -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel="stylesheet" href="assets/css/dragdrop.css" >
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
                <li class="breadcrumb-item"><a href="edit.php">Dashboard</a></li>
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
                <?php include_once('include/components.php'); ?>
            </section>

            <section class="col-lg-9">
              <div class="container px-4 mb-3">
                <div class="row justify-content-end">
                      <button type="button" class="btn btn-primary" onclick="saveDashboard()">Save</button>
                </div>
                
                <div class="row">
                    <div class="form-group col-md-9">
                      <label>Title</label>
                      <input type="text" class="form-control" id="dashboard-title" value="<?= $dashboard_detail['name'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                      <label>Color</label>
                      <input type="color" class="form-control" id="dashboard-color" value="<?= $dashboard_detail['color'] ?>">
                    </div>
                </div>
              </div>
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
        stop: function(event, ui) {
          let closeBtn = `<div class="badge badge-danger remove-col" onclick="deleteComponent(this)">X</div>`;
          if (ui.item.parent().attr('id') != 'component-sidebar') {
            console.log('in');
            ui.item.append(closeBtn);
            let i = ui.item.clone();
            i.find('.remove-col').remove();
            i.appendTo('#component-sidebar');
          }else{
            ui.item.find('.remove-col').remove();
          }

          let components = Array.from(document.getElementById("component-sidebar").children);
          components.sort(function(a, b) {
            return a.getAttribute('data-counter') - b.getAttribute('data-counter');
          });
          document.getElementById("component-sidebar").innerHTML = '';
          let filterComponents = [];
          components.forEach(function(value, index, self) {
            let counter = value.getAttribute('data-counter');
            let yes = true;
            for (x = 0; x < filterComponents.length; x++) {
              let c = filterComponents[x].getAttribute('data-counter');
              if (c == counter) {
                yes = false;
                break;
              }
            }
            if (yes) {
              filterComponents.push(value);
            }
          });
          for (let component of filterComponents) {
            document.getElementById("component-sidebar").insertAdjacentElement('beforeend', component);
          }
        }
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
      return totalRows++;
    }

    function addColumnOnRow(rowId, columns, dbRow = null) {
      let cols = ``;
      // console.log(dbRow);
      columns.forEach(function(col, index) {
        let content = '';
        if(dbRow != null){
          let pos = dbRow['positions'].findIndex(function(v){
            return v == index;
          });
          if(pos >= 0){
            let componentId = dbRow['componentIds'][pos];
            if(Array.isArray(componentId)){
              componentId.forEach(function(id,i){
                let div = $(`div[data-component-id="${id}"]`);
                let card = `<div class="card mb-1" data-component-id="${id}" >${div.html()}<div class="badge badge-danger remove-col" onclick="deleteComponent(this)">X</div></div>`;
                content += card;
              });
            }else{
              let div = $(`div[data-component-id="${componentId}"]`);
              content = `<div class="card mb-1" data-component-id="${componentId}" >${div.html()}<div class="badge badge-danger remove-col" onclick="deleteComponent(this)">X</div></div>`;
            }
            // div.remove();
          }
        }
        cols += `<div class="connectedSortable col-md-${col}" data-col="${col}" data-col-position="${index}">${content}</div>`;
      });
      cols += `<div class="badge badge-danger remove-row" onclick="deleteRow(${rowId})">X</div>`;
      let row = $(`#row-${rowId}`);
      row.attr('data-row-position',rowId);
      row.attr('data-columns',columns);
      row.html(cols);
      row.addClass('col-row-height');
      init();
    }

    function fetch_dashboard_data(){
      let data = {
        dashboardId:"<?= $dashboard_id ?>",
      };
      $.ajax({
        method:"post",
        url:"<?= APP_URL ?>/ajax/fetchDashboard.php",
        dataType:'json',
        data:data,
        success:function(response,textStatus,xhr){
          // console.log(response);
          Object.keys(response.rows).forEach(rowPosition => {
            let rowId = addRow();
            let row = response.rows[rowPosition];
            let pattern = row.pattern;
            console.log(row);
            addColumnOnRow(rowId,pattern,row);
          });
        },
        error:function(err){
          Swal.fire({
            icon:"error",
            title:"Internal Server Error!",
            text:"Fetching dashboard detail failed!"
          });
          console.log(err);
        }
      });
    }
    fetch_dashboard_data();

    saveDashboard = () => {

      if($("#dashboard-title").val() == ""){
        Swal.fire({
          icon:"warning",
          title:"Empty!",
          text:"Please Enter Dashboard Title and Color"
        });
        return void(0);
      }

      let dashboardDetail = {
        name:$("#dashboard-title").val(),
        color:$("#dashboard-color").val()
      };

      let data = [];
      let selectors = document.querySelectorAll('.connectedSortable[data-col]');
      selectors.forEach(function(val,index,array){
        let rowPosition = val.parentNode.getAttribute('data-row-position');
        let cols = val.parentNode.getAttribute('data-columns');
        let col = val.getAttribute('data-col');

        let colPosition = val.getAttribute('data-col-position');
        let componentId = val.childNodes[0];
        
        if(componentId){
          componentId = componentId.getAttribute('data-component-id');
        }else{
          componentId = null;
        }
        
        let vColPosition = [];
        if(val.childElementCount > 0){
          componentId = [];
          for(let i = 0;i<val.childElementCount;i++){
            let child = val.children[i];
            componentId.push(child.getAttribute('data-component-id'));
            vColPosition.push(i);
          }
        }

        let component = {rowPosition,cols,col,colPosition,vColPosition,componentId,dashboardId:"<?= $dashboard_id ?>"};
        data.push(component);
      }); 
      
      /**
       * Send Post Request
       */
      $.ajax({
        method:"post",
        url:"<?= APP_URL ?>/ajax/editDashboard.php",
        data:{data:data,dashboard:dashboardDetail},
        success:function(response,textStatus,xhr){
          Swal.fire({
            icon:"success",
            title:"Dashboard Updated!",
            text:"Dashboard Updated Successfully."
          }).then((result) => {
            window.location.replace('index.php?id=<?= $dashboard_id ?>');
          });
        },
        error:function(err){
          Swal.fire({
            icon:"error",
            title:"Internal Server Error!",
            text:"Something Went Wrong!"
          });
        }
      });
      // console.log(data);
    }

    function deleteRow(id){
      $("#row-"+id).remove();
    }

    function deleteComponent(that){
      $(that).closest('.ui-sortable-handle').remove();
    }
  </script>
</body>

</html>