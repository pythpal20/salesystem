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
  $dt = $res1->fetch_assoc(); 
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
  <link href="../css/plugins/dataTables/new/datatables.min.css" rel="stylesheet">
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
                <span class="block m-t-xs font-bold"><?php echo $dt['user_nama']; ?></span>
                <span class="text-muted text-xs block">
                  <?php echo $dt['level']; ?>
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
              <?php if($dt['level'] !== 'sales'): ?>
                <li><a href="customer.php">Customer</a></li>
              <?php endif ?>
              <?php if($dt['level'] == 'sales'): ?>
                <li><a href="csBysales.php">Customer</a></li>
              <?php endif ?>
              <li><a href="area.php">Area</a></li>
              <li class="active"><a href="datassg.php">Data Item</a></li>
            </ul>
          </li>
          <li>
            <?php if ($dt['level'] !== 'sales') : ?>
              <a href="dbpurchaseorder.php"><i class="fa fa-calculator"></i> <span class="nav-label">Data Order</span></a>
            <?php endif ?>
            <!-- =============== -->
            <?php if ($dt['level'] == 'sales') : ?>
              <a href="dataposales.php"><i class="fa fa-calculator"></i> <span class="nav-label">Data Order</span></a>
            <?php endif ?>
          </li>
          <li> <!-- fpp -->
            <?php if ($dt['level'] !== 'sales') : ?>
              <a href="datafpp.php"><i class="glyphicon glyphicon-folder-close"></i> <span class="nav-label">Data FPP</span></a>
            <?php endif; ?>
            <?php if ($dt['level'] == 'sales') : ?>
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
            <?php if($dt['level'] == 'superadmin') : ?>
            <a href="itemForm.php" class="btn btn-info"><span class="fa fa-plus-circle"></span> Tambah Produk</a>
            <?php endif ?>
          </div>
          <div class="col-lg-12">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Data List Produk</h5>
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
                <div class="">
                  <table class="display table-bordered table-hover" id="tabelItem">
                    <thead>
                      <tr>
                        <th>Barcode</th>
                        <th data-priority="1">SKU</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th data-priority="2">Harga</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../js/jquery-3.1.1.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.js"></script>
  <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
  <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
  <!-- datatable -->
  <script src="../js/plugins/dataTables/new/datatables.min.js"></script>
  <!-- Custom and plugin javascript -->
  <script src="../js/inspinia.js"></script>
  <script src="../js/plugins/pace/pace.min.js"></script>
  <!-- Chosen -->
  <script src="../js/plugins/chosen/chosen.jquery.js"></script>
  <script src="../js/plugins/select2/select2.full.min.js"></script>
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
  <script type="text/javascript">
    $(document).ready(function() {
      $('#tabelItem').DataTable( {
        pageLength: 15,
        responsive: true,
        "bPaginate": true,
        "processing": true,
        "serverSide": true,
        "ajax": "route/getItem.php",
        columnDefs: [
          { responsivePriority: 1, targets: 0 },
          { responsivePriority: 2, targets: -1 }]
      } );
    } );
    // $(document).ready( function () {
    //   $.ajax({
    //   url: "route/dataItem.php",
    //   method: "GET",
    //   success: function(response){
    //     $("#tabelItem").html(response)
    //     var oTable = $('#table_id').dataTable( {
    //       pageLength: 10,
    //       responsive: true,
    //       "sScrollY": "100%",
    //       "bPaginate": true,
    //       columnDefs: [
    //       { responsivePriority: 1, targets: 0 },
    //       { responsivePriority: 2, targets: -1 }]
    //     } );
    //       //console.log(response);
    //     }
    //   })
    // });
  </script>