<?php
  include 'route/config.php';
  session_start(); 
  if (!isset($_SESSION['usernameu'])){
    header("Location: ../index.php");
  }
  $id = $_SESSION['idu'];
  $query = "SELECT * FROM master_user
  WHERE user_id='$id'"; 
  $mwk = $db1->prepare($query); 
  $mwk->execute();
  $res1 = $mwk->get_result();
  $data = $res1->fetch_assoc(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="apple-touch-icon" sizes="76x76" href="../img/apple-icon.png">
  <link rel="icon" type="image/png" href="../img/favicon.png">
  <title>Mr. Kitchen</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="../css/animate.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
  <!-- <link href="../css/plugins/dataTables/datatables.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/b-1.7.1/b-html5-1.7.1/b-print-1.7.1/r-2.2.9/rr-1.2.8/datatables.min.css"/>
  <link href="../css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
  <link href="../css/plugins/select2/select2.min.css" rel="stylesheet">
  <link href="../css/plugins/datapicker/datepicker3.css" rel="stylesheet">
  <link href="../css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
  <script src="../js/plugins/chartJs/Chart.min.js"></script>
  <link href="../css/plugins/footable/footable.core.css" rel="stylesheet">
</head>
<body>
  <div id="wrapper">
    <nav style="" class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
          <li class="nav-header">
            <div class="dropdown profile-element">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="block m-t-xs font-bold"><?php echo $data['user_nama']; ?></span>
                <span class="text-muted text-xs block">
                  <?php echo $data['level']; ?>
                </span>
              </a>
            </div>
            <div class="logo-element">
              <div style="height: 30px; width: 30px; background-color: #dd0000; border-radius: 50%; display: inline-block;">
                SO
              </div>
            </div>
          </li>
          <li>
            <a href="dashboard.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
          </li>
          <li class="active">
            <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Master</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <?php if($data['level'] !== 'sales'): ?>
                <li class="active"><a href="customer.php">Customer</a></li>
              <?php endif ?>
              <?php if($data['level'] == 'sales'): ?>
                <li class="active"><a href="csBysales.php">Customer</a></li>
              <?php endif ?>
              <li><a href="area.php">Area</a></li>
              <li><a href="datassg.php">Data Item</a></li>
            </ul>
          </li>
          <li>
            <?php if ($data['level'] !== 'sales') : ?>
              <a href="dbpurchaseorder.php"><i class="fa fa-calculator"></i> <span class="nav-label">Data Order</span></a>
            <?php endif ?>
            <!-- =============== -->
            <?php if ($data['level'] == 'sales') : ?>
              <a href="dataposales.php"><i class="fa fa-calculator"></i> <span class="nav-label">Data Order</span></a>
            <?php endif ?>
          </li>
          <li> <!-- fpp -->
            <?php if ($data['level'] !== 'sales') : ?>
              <a href="datafpp.php"><i class="glyphicon glyphicon-folder-close"></i> <span class="nav-label">Data FPP</span></a>
            <?php endif; ?>
            <?php if ($data['level'] == 'sales') : ?>
              <a href="myfpp.php"><i class="glyphicon glyphicon-folder-close"></i> <span class="nav-label">My FPP</span></a>
            <?php endif; ?>
          </li>
          <li>
            <a href="user.php"><i class="fa fa-user"></i> <span class="nav-label">Kelola User</span></a>
          </li>
          <li>
            <a href="logout.php"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
          </li>
        </ul>
      </div>
    </nav>
    <div id="page-wrapper" class="gray-bg">
      <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0;background-color:#dd0000;">
          <div class="navbar-header">
            <a style="background-color:#dd0000;color:white;" class="navbar-minimalize minimalize-styl-2 btn " href="#"><i class="fa fa-bars"></i> </a>
            <a href="#" class="navbar-brand">
              <img src="../img/mkc2.png" height="48" width="120" alt="CoolBrand">
            </a>
          </div>
        </nav>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-sm-12 m-b-xs">
            <?php if($data['level'] !== 'sales') : ?>  <!-- 13 - 08 - 2021 by Pak Sob, sales tidak bisa input customer -->
            <a href="customer_add.php" class="btn btn-info"><span class="fa fa-plus-circle"></span> Tambah Customer</a>
            <?php endif ?>
          </div>
          <div class="col-lg-12">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Data Customer</h5>
                <div class="ibox-tools">
                  <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                  </a>
                  <a class="close-link">
                    <i class="fa fa-times"></i>
                  </a>
                </div>
              </div>
              <div class="ibox-content">
                <!-- <div class="row">
                  <div class="col-sm-8 m-b-xs"></div>
                  <div class="col-sm-4 m-b-xs">
                    <div class="input-group float-right">
                      <input type="text" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Cari Data . . .">
                      <div class="input-group-prepend">
                        <span class="input-group-addon text-info"><span class="fa fa-search"></span> </span>
                      </div>
                    </div>
                  </div>
                </div> -->
                <div class="">
                  <table class="table table-bordered table-hover" id="memListTable">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>ID Register</th>
                        <th data-priority="1">Customer</th>
                        <th >Kota</th>
                        <th>Input By</th>
                        <th data-priority="2">Aksi</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <div class="ibox-footer">
              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="../js/jquery-3.1.1.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
  <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
  <!-- datatable -->
  <!-- <script src="../js/plugins/dataTables/datatables.min.js"></script> -->
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/b-1.7.1/b-html5-1.7.1/b-print-1.7.1/r-2.2.9/rr-1.2.8/datatables.min.js"></script>
  <!-- Custom and plugin javascript -->
  <script src="../js/inspinia.js"></script>
  <script src="../js/plugins/pace/pace.min.js"></script>
  <!-- Chosen -->
  <script src="../js/plugins/chosen/chosen.jquery.js"></script>
  <!-- Data picker -->
  <script src="../js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <!-- Sweet Alert -->
  <script src="../js/plugins/sweetalert/sweetalert.min.js"></script>
  <!-- FooTable -->
  <script src="../js/plugins/footable/footable.all.min.js"></script>
  <script src="../js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
  <script src="../js/plugins/flot/jquery.flot.js"></script>
  <script src="../js/plugins/flot/jquery.flot.tooltip.min.js"></script>
  <script src="../js/plugins/flot/jquery.flot.spline.js"></script>
  <script src="../js/plugins/flot/jquery.flot.resize.js"></script>
  <script src="../js/plugins/flot/jquery.flot.pie.js"></script>
  <script src="../js/plugins/morris/raphael-2.1.0.min.js"></script>
  <script src="../js/plugins/morris/morris.js"></script>
  <script>
    $(document).ready(function(){
      var table = $('#memListTable').DataTable( {
        pageLength: 15, 
        "processing"   : true,
        "serverSide"   : true,
        "ajax"         : "route/get_data_customer.php?kategori; ?>",
        dom            : 'Bfrtip',
        button         : [
        'colvis','excel','print'],
        responsive: true,
        columnDefs:  [
        {
          "targets": -1,
          "data": null,
          "defaultContent": "<center><button class='btn btn-info btn-sm view_data' title='View Detail' rel='tooltip'><span class='fa fa-eye'></span></button></center>" 
        }
        ]
      });
      // Penomoran 
      table.on('draw.dt', function () {
        var info = table.page.info();
        table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
          cell.innerHTML = i + 1 + info.start;
        });
      });
      // table.on( 'order.dt search.dt', function () {
      // table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
      // cell.innerHTML = i+1;
      //     } );
      // } ).draw();
      $('#memListTable tbody').on( 'click', '.view_data', function () {
        var data = table.row( $(this).parents('tr')).data();
        var data3 = data[5];
        var data3 = btoa(data3);
        var id = data[0];
        $.ajax({
          url: "route/dtlCustomer.php",
          method: "POST",
          data: {
            id: id
          },
          success: function(data) {
            console.log(data);
            $('#viewCust').html(data);
            $('#viewDetail').modal('show');

          }
        });
      });

      $('#memListTable tbody').on( 'click', '.tblEdit', function () {
        var data = table.row( $(this).parents('tr')).data();
        var data3 = data[3];
        var data3 = btoa(data3);
        window.location.href = "custEdit.php?id="+ data[0];
      });

      $('#memListTable tbody').on( 'click', '.tblDelete', function () {
        var data = table.row( $(this).parents('tr')).data();
        window.location.href = "custDelete.php?id="+ data[0];
      });

    });
  </script>
  <div id="viewDetail" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Customer</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body" id="viewCust">

        </div>
      </div>
    </div>
  </div>
</body>
</html>