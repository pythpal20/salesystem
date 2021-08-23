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
          <li>
            <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Master</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <?php if($dt['level'] !== 'sales'): ?>
                <li><a href="customer.php">Customer</a></li>
              <?php endif ?>
              <?php if($dt['level'] == 'sales'): ?>
                <li><a href="csBysales.php">Customer</a></li>
              <?php endif ?>
              <li><a href="area.php">Area</a></li>
              <li><a href="datassg.php">Data Item</a></li>
            </ul>
          </li>
          <li class="active">
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
            <?php if($dt['level'] !== 'admin') : ?>
            <a href="dbpoform.php" class="btn btn-info"><span class="fa fa-plus-circle"></span> Tambah Order</a>
            <?php endif ?>
          </div>
          <div class="col-lg-12">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Data Sales Order</h5>
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
                <div class="row">
                  <div class="col-sm-8"></div>
                  <div class="col-sm-4 m-b-xs">
                    <div class="input-group m-b">
                      <input type="text" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Ketik disini untuk mencari data. . .">
                      <div class="input-group-prepend">
                        <span class="input-group-addon"><span class="fa fa-search"></span></span>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                // Cek apakah terdapat data pada page URL
                $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
                if (!isset($_POST['search'])) {
                  $limit = 15;
                  $where = "";
                } else {
                  $page = 1;
                  $link_prev = 1;
            //$tglpo = $_POST['tgl_po'];
                  $noso = $_POST['po'];
                  $perusahaan = $_POST['perusahaan'];
                  $category = $_POST['category'];
                  $sales = $_POST['sales'];
                  $city = $_POST['city'];

                  if (($noso == "") && ($perusahaan == "perusahaan") && ($category == "Kategori") && ($sales == "Sales") && ($city == "")) {
                    echo "<script>window.location.replace('dbpurchaseorder.php'); </script>";
                  } else {

                    $limit = 50000;
                    $info = "Data dengan ";

                    if ($noso != "") {
                      $s_po = "noso LIKE '%" . $noso . "%'";
                      $info = $info . ", noso <b>" . $noso . " </b> ";
                    } else {
                      $s_po = "";
                    }
                    if ($perusahaan != "perusahaan") {
                      $s_perusahaan = "customer_id = '" . $perusahaan . "'";
                      $sql_perusahaan = $pdo->prepare("SELECT * FROM master_customer WHERE customer_id='" . $perusahaan . "'");
                      $sql_perusahaan->execute();
                      while ($perusahaan = $sql_perusahaan->fetch()) {
                        $info = $info . "customer_nama <b>" . $perusahaan['customer_nama'] . "</b> ";
                      }
                    } else {
                      $s_perusahaan = "";
                    }

                    if ($category != "Kategori") {
                      $s_category = "id_category = '" . $category . "'";
                      $sql_category = $pdo->prepare("SELECT * FROM category WHERE id_category='" . $category . "'");
                      $sql_category->execute();
                      while ($category = $sql_category->fetch()) {
                        $info = $info . "kategori <b>" . $category['kategori'] . "</b> ";
                      }
                    } else {
                      $s_category = "";
                    }


                    if ($sales != "Sales") {
                      $s_sales = "id_sales = '" . $sales . "'";
                      $sql_sales = $pdo->prepare("SELECT * FROM sales WHERE id_sales='" . $sales . "'");
                      $sql_sales->execute();
                      while ($sales = $sql_sales->fetch()) {
                        $info = $info . ", sales <b>" . $sales['nama'] . "</b> ";
                      }
                    } else {
                      $s_sales = "";
                    }
                    if ($city != "") {
                      $s_city = "kota LIKE '%" . $city . "%'";
                      $info = $info . ", kota <b>" . $city . " </b> ";
                    } else {
                      $s_city = "";
                    }
                    if (($s_perusahaan != "") || ($s_category != "") || ($s_sales != "") || ($s_area != "") || ($s_city != "")) {
                      $where = "WHERE ";

                      if ($s_perusahaan != "") {
                        $where = $where . $s_perusahaan;
                      }
                      if ($s_perusahaan != "") {
                        if (($s_category != "") || ($s_sales != "") || ($s_city != "")) {
                          $where = $where . " AND ";
                        }
                      }

                      if ($s_category != "") {
                        $where = $where . $s_category;
                      }

                      if ($s_category != "") {
                        if (($s_sales != "") || ($s_city != "")) {
                          $where = $where . " AND ";
                        }
                      }

                      if ($s_sales != "") {
                        $where = $where . $s_sales;
                      }

                      if ($s_sales != "") {
                        if (($s_area != "")  || ($s_city != "")) {
                          $where = $where . " AND ";
                        }
                      }



                      if ($s_city != "") {
                        $where = $where . $s_city;
                      }
                    } else {
                      $where = "";
                    }

                    $sql_jml = $pdo->prepare("SELECT COUNT(*) FROM salesorder_hdr " . $where);
                    $sql_jml->execute(); // Eksekusi querynya
                    $get_jml = $sql_jml->fetchColumn();

                    $info = $info . " berjumlah <b>" . $get_jml . " data </b>";
                  }
                }
                ?>
                <div class="">
                  <table class="table tablePo table-bordered table-hover" data-filter=#filter>
                    <thead scoop="row">
                      <tr>
                        <th>#</th>
                        <th>No. So</th>
                        <th data-hide="phone">Tanggal Order</th>
                        <th>Nama Customer</th>
                        <th data-hide="phone">Amount</th>
                        <th data-hide="phone">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Jumlah data per halamanya
                      // Buat query untuk menampilkan daa ke berapa yang akan ditampilkan pada tabel yang ada di database
                      $limit_start = ($page - 1) * $limit;
                      // Buat query untuk menampilkan data sesuai limit yang ditentukan
                      $sql = $pdo->prepare("SELECT * FROM salesorder_hdr WHERE sales='" .$dt['user_nama']. "' ORDER BY tgl_po DESC LIMIT " . $limit_start . "," . $limit);
                      $sql->execute(); // Eksekusi querynya

                      $no = $limit_start + 1; // Untuk penomoran tabel
                      while ($data = $sql->fetch()) { // Ambil semua data dari hasil eksekusi $sql
                      ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $data['noso']; ?></td>
                        <td>
                          <?php
                            $sql2 = $pdo->prepare("SELECT tgl_po FROM salesorder_hdr WHERE noso = '" . $data['noso'] . "'");
                            $sql2->execute();
                            while ($noso = $sql2->fetch()) {
                                echo $noso['tgl_po'];
                            }
                          ?>
                        </td>
                        <td>
                          <?php
                            $sql2 = $pdo->prepare("SELECT customer_nama FROM master_customer WHERE customer_id = '" . $data['customer_id'] . "'");
                            $sql2->execute();
                            while ($perusahaan = $sql2->fetch()) {
                                echo $perusahaan['customer_nama'];
                            }
                          ?>
                        </td>
                        <td>
                          <?php 
                            $amt= "SELECT SUM(harga_total) AS amnt, ongkir FROM salesorder_dtl pd
                            JOIN salesorder_hdr ph ON pd.noso = ph.noso
                            WHERE pd.noso = '" . $data['noso'] . "'";
                            $mwk = $db1->prepare($amt);
                            $mwk -> execute();
                            $amtd = $mwk->get_result();
                            $dtb = $amtd->fetch_assoc();
                            echo 'RP. ' . number_format($dtb['amnt']+$dtb['ongkir'],0,".",".");
                        ?>
                        </td>
                        <td>
                          <button type="button" name="view" value="Lihat Detail" id-po="<?php echo $data["noso"]; ?>" class="btn btn-info btn-xs view_data" title="View Detail" rel="tooltip"><span class="glyphicon glyphicon-eye-open"></span>
                          </button>
                          <?php if($dt['level'] !== 'sales') : ?>
                          <a href="so_edit.php?id=<?php echo $data['noso']; ?>" title="Ubah" rel="tooltip" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                          <a href="route/orderDelete.php?id=<?php echo $data['noso']; ?>" class="btn btn-danger btn-xs" title="hapus" onclick="return confirm('Apakah Anda yakin akan Menghapus Po ini ?')">
                            <span class="glyphicon glyphicon-erase"></span>
                          </a>
                        <?php endif ?>
                        <?php if($dt['level'] == 'sales') : ?>
                          <a href="formfpp.php?id=<?php echo $data['noso']; ?>" title="FPP" rel="tooltip" class="btn btn-success btn-xs"><span class="fa fa-pencil-square-o"></span>
                          </a>
                        <?php endif ?>
                        </td>
                      </tr>
                      <?php
                        $no++; // Tambah 1 setiap kali looping
                    }
                    ?>
                    </tbody>
                  </table>
                  <div>
                    <ul class="pagination">
                      <!-- LINK FIRST AND PREV -->
                      <?php
                      if ($where == "") {
                        if ($page == 1) {
                      ?>
                      <li class="disabled"><a href="#">First</a></li>
                      <li class="disabled"><a href="#">&laquo;</a></li>
                      <?php
                      } else { // Jika buka page ke 1
                          $link_prev = ($page > 1) ? $page - 1 : 1;
                      ?>
                      <li><a href="dbpurchaseorder.php?page=1">First</a></li>
                      <li><a href="dbpurchaseorder.php?page=<?php echo $link_prev; ?>">&laquo;</a></li>
                      <?php
                        }
                      ?>
                      <!-- LINK NUMBER -->
                      <?php
                      // Buat query untuk menghitung semua jumlah data
                      $sqljml = $pdo->prepare("SELECT COUNT(*) " . $where . "AS jumlah FROM salesorder_hdr");
                      $sqljml->execute(); // Eksekusi querynya
                      $get_jumlah = $sqljml->fetch();

                      $jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamanya
                      $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
                      $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link member
                      $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
                      for ($i = $start_number; $i <= $end_number; $i++) {
                        $link_active = ($page == $i) ? 'class="active"' : '';
                      ?>
                      <li <?php echo $link_active; ?>><a href="dbpurchaseorder.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                      <?php
                      }
                      ?>

                      <!-- LINK NEXT AND LAST -->
                      <?php
                        // Jika page sama dengan jumlah page, maka disable link NEXT nya
                        // Artinya page tersebut adalah page terakhir
                        if ($page == $jumlah_page) { // Jika page terakhir
                      ?>
                      <li class="disabled"><a href="#">&raquo;</a></li>
                      <li class="disabled"><a href="#">Last</a></li>
                      <?php
                        } else { // Jika bukan page terakhir
                            $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
                      ?>
                      <li><a href="dbpurchaseorder.php?page=<?php echo $link_next; ?>">&raquo;</a></li>
                      <li><a href="dbpurchaseorder.php?page=<?php echo $jumlah_page; ?>">Last</a></li>
                      <?php
                            }
                        }
                      ?>
                    </ul>
                  </div>
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
    $(document).ready(function(){
      $('.tablePo').footable();
      $('.tableModal').footable();
    });
  </script>
  <script>
    $(document).ready(function() {
      //Begin Tampil Detail Karyawan
      $('.view_data').click(function() {
        var id = $(this).attr("id-po");
        $.ajax({
          url: "route/viewOrder.php",
          method: "POST",
          data: {
            id: id
          },
          success: function(data) {
            console.log(data);
            $('#detaiOrder').html(data);
            $('#viewDetail').modal('show');

          }
        });
      });
    });
  </script>
  <div id="viewDetail" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Order</h4>
            </div>
            <div class="modal-body" id="detaiOrder">

            </div>
        </div>
    </div>
</div>