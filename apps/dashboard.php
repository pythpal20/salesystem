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
  <link href="../css/plugins/dataTables/datatables.min.css" rel="stylesheet">
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
          <li class="active">
            <a href="dashboard.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
          </li>
          <li>
            <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Master</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <?php if($data['level'] !== 'sales'): ?>
                <li><a href="customer.php">Customer</a></li>
              <?php endif ?>
              <?php if($data['level'] == 'sales'): ?>
                <li><a href="csBysales.php">Customer</a></li>
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
        <h2>Selamat datang <?php echo $data['user_nama']; ?>,</h2>
        <div class="row">
          <div class="col-lg-6">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Informasi Order/Penjualan bulan ini</h5>
                <div class="ibox-tools">
                  <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                  </a>
                  <a class="close-link">
                    <i class="fa fa-times"></i>
                  </a>
                </div>
              </div>
              <?php
                $ttl_po = "SELECT COUNT(noso) AS total FROM salesorder_hdr WHERE MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND sales ='".$data['user_nama']."'";
                $mwk = $db1->prepare($ttl_po);
                $mwk->execute();
                $reslt = $mwk->get_result();
                $tpo = $reslt->fetch_assoc();

                $ttl_po2 = "SELECT COUNT(noso) AS total FROM salesorder_hdr WHERE MONTH(tgl_po) = MONTH(CURRENT_DATE())";
                $mwk = $db1->prepare($ttl_po2);
                $mwk->execute();
                $reslt2 = $mwk->get_result();
                $tpo2 = $reslt2->fetch_assoc();

                $ttl_amt = "SELECT SUM(sd.harga_total) AS total_hrg, sh.sales FROM salesorder_dtl sd 
                JOIN salesorder_hdr sh ON sd.noso = sh.noso
                WHERE MONTH(sd.tgl_po) = MONTH(CURRENT_DATE()) AND sh.sales ='".$data['user_nama']."'";
                $mwk = $db1->prepare($ttl_amt);
                $mwk->execute();
                $resl = $mwk->get_result();
                $tpa = $resl->fetch_assoc();

                $ttl_amt2 = "SELECT SUM(sd.harga_total) AS total_hrg, sh.sales FROM salesorder_dtl sd 
                JOIN salesorder_hdr sh ON sd.noso = sh.noso
                WHERE MONTH(sd.tgl_po) = MONTH(CURRENT_DATE())";
                $mwk = $db1->prepare($ttl_amt2);
                $mwk->execute();
                $resl2 = $mwk->get_result();
                $tpa2 = $resl2->fetch_assoc();
                
                $produk = "SELECT model, COUNT(model) AS modus, SUM(qty) AS total FROM salesorder_dtl 
                WHERE MONTH(tgl_po) = MONTH(CURRENT_DATE()) AND YEAR(tgl_po) = YEAR(CURRENT_DATE())
                GROUP BY model ORDER BY total DESC LIMIT 15";
                $mwk = $db1->prepare($produk);
                $mwk->execute();
                $hasil_prod = $mwk->get_result();
              ?>
              <?php if($data['level'] == 'sales') : ?>
              <div class="ibox-content">
                <ul class="list-group clear-list m-t">
                  <li class="list-group-item fist-item">
                    <span class="float-right">
                      <?php echo $tpo['total']; ?> PO
                    </span>
                    <span class="label label-success">1</span> Jumlah Penjualan anda bulan ini
                  </li>
                  <li class="list-group-item fist-item">
                    <span class="float-right">
                      <?php echo 'Rp. ' . number_format($tpa['total_hrg'],0,'.','.'); ?>
                    </span>
                    <span class="label label-primary">2</span> Total amount bulan ini
                  </li>
                </ul>
              </div>
              <?php endif ?>
              <?php if($data['level'] !== 'sales') : ?>
              <div class="ibox-content">
                <ul class="list-group clear-list m-t">
                  <li class="list-group-item fist-item">
                    <span class="float-right">
                      <?php echo $tpo2['total']; ?> PO
                    </span>
                    <span class="label label-success">1</span> Jumlah Penjualan bulan ini
                  </li>
                  <li class="list-group-item fist-item">
                    <span class="float-right">
                      <?php echo 'Rp. ' . number_format($tpa2['total_hrg'],0,'.','.'); ?>
                    </span>
                    <span class="label label-primary">2</span> Total amount bulan ini
                  </li>
                </ul>
              </div>
              <?php endif ?>
            </div>
          </div>
          <?php if($data['level'] !== 'sales') : ?>
          <div class="col-lg-6">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>List Jumlah PO by Sales</h5>
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
                <div class="table-responsive">
                  <table class="table table-hover ftable" data-page-size="5">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Jumlah PO</th>
                        <th align="right" data-type="numeric" data-sort-initial="true">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sql = "SELECT * FROM salesorder_hdr GROUP BY sales";
                        $mwk = $db1->prepare($sql);
                        $mwk -> execute();
                        $hasil = $mwk->get_result();
                        while ($hs = $hasil->fetch_assoc()) {
                      ?>
                      <tr>
                        <td>
                          <?php echo $hs['sales']; ?>
                        </td>
                        <td>
                          <?php 
                            $total_po = "SELECT COUNT(noso) AS ttl_po FROM salesorder_hdr WHERE sales='".$hs['sales']."';";
                            $mwk = $db1->prepare($total_po);
                            $mwk -> execute();
                            $pottl = $mwk->get_result();
                            $ttlpo = $pottl->fetch_assoc();
                            echo $ttlpo['ttl_po'];
                          ?>
                        </td>
                        <td align="right">
                          <?php 
                            $sql3 = "SELECT SUM(harga_total) AS amount FROM salesorder_dtl sd 
                            JOIN salesorder_hdr sh ON sd.noso= sh.noso
                            WHERE sh.sales = '".$hs['sales']."'";
                            $mwk = $db1->prepare($sql3);
                            $mwk -> execute();
                            $amnt = $mwk->get_result();
                            $mt = $amnt->fetch_assoc();
                            echo $mt['amount']; 
                          ?>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3">
                          <ul class="pagination float-right"></ul>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="ibox-footer">
                  <em>*Amount belum termasuk Ongkir</em>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>15 Produk Terlaris Bulan ini</h5>
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
                <div class="table-responsive">
                  <table class="table table-hover ftable" data-page-size="5">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>SKU</th>
                        <th>Jumlah Orderan</th>
                        <th data-type="numeric" data-sort-initial="descending">Total Qty</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no=1; while ($prod = $hasil_prod->fetch_assoc()) : ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $prod['model']; ?></td>
                          <td><?php echo $prod['modus']; ?></td>
                          <td><?php echo $prod['total']; ?></td>
                        </tr>
                      <?php endwhile ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4">
                          <ul class="pagination float-right"></ul>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php endif ?>
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
  <script src="../js/plugins/dataTables/datatables.min.js"></script>
  <script src="../js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
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
    $(document).ready(function() {
      $('.ftable').footable();
    });
  </script>
</body>
</html>