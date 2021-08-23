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
      <?php 
        $noso = $_GET['id'];
        $sql = "SELECT * FROM salesorder_hdr sh
        JOIN master_customer ms ON sh.customer_id = ms.customer_id
        JOIN master_wilayah mw ON ms.customer_kota = mw.wilayah_id
        WHERE noso = '$noso'";
        $mwk = $db1->prepare($sql);
        $mwk -> execute();
        $hsl = $mwk->get_result();
        $rw = $hsl->fetch_assoc();
      ?>
      <?php 
        $cek = "SELECT * FROM master_fpp WHERE noso = '".$_GET['id']."'";
        $mwk = $db1->prepare($cek);
        $mwk -> execute();
        $result_cek = $mwk->get_result();
      ?>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <?php if($result_cek->num_rows > 0) { ?>
          <div class="col-lg-12">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Form Perubahan PO</h5>
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
                <h4>Pengajuan untuk PO ini sudah ada!</h4>
              </div>
              <div class="ibox-footer">
                <button class="btn btn-warning back"><span class="glyphicon glyphicon-arrow-left"></span> Kembali
                </button>
              </div>
            </div>
          </div>
          <?php } else { ?>
          <div class="col-lg-12">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Form Perubahan PO</h5>
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
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-hover" width="100%" style="font-size: 0.817em">
                        <tr>
                          <th>Nama Konsumen</th>
                          <td>:</td>
                          <td><?php echo $rw['customer_nama'];?></td>
                          <th>Kota</th>
                          <td>:</td>
                          <td><?php echo $rw['wilayah_nama']; ?></td>
                        </tr>
                      </table>                 
                    </div>
                    <hr/>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="noso">No. SCO</label>
                      <input type="text" name="noso" class="form-control" value="<?php echo $rw['noso'];?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-2 col-md-pull-2">
                    <div class="form-group">
                      <label>Tanggal PO</label>
                      <input type="text" name="" class="form-control" value="<?php echo $rw['tgl_po']; ?>" readonly>
                    </div>
                  </div>
                  <div class="col-md-2 col-md-push-2">
                    <div class="form-group">
                      <label>Tanggal Kirim</label>
                      <input type="text" name="" class="form-control" value="<?php echo $rw['tgl_krm']; ?>" readonly>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="formHeader">
            <form id="formHdr">
              <div class="col-lg-12">
                <div class="ibox">
                  <div class="ibox-title">
                    <h5>Alasan Perubahan PO</h5>
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
                    <input type="hidden" name="noso" id="noso" value="<?php echo $rw['noso']; ?>">
                    <input type="hidden" name="cs" id="cs" value="<?php echo $rw['customer_id']; ?>">
                    <input type="hidden" name="tglpo" id="tglpo" value="<?php echo $rw['tgl_po']; ?>">
                    <input type="hidden" name="tglkrm" id="tglkrm" value="<?php echo $rw['tgl_krm']; ?>">
                    <input type="hidden" name="tglfpp" id="tglfpp" value="<?php echo date('Y-m-d'); ?>">
                    <input type="hidden" name="uinput" id="uinput" value="<?php echo $dt['user_nama'];?>">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="i-checks">
                          <label> <input type="checkbox" name="als1" id="als1" value="Spesifikasi barang tidak sesuai (salah SKU)"> <i></i> Spesifikasi barang tidak sesuai (salah SKU) </label>
                        </div>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="als2" id="als2" value="Kualitas barang tidak sesuai (rusak)"> <i></i> Kualitas barang tidak sesuai (rusak) </label>
                        </div>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="als3" id="als3" value="Informasi order dari sales/ Marketing tidak sesuai"> <i></i> Informasi order dari sales/ Marketing tidak sesuai </label>
                        </div>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="als4" id="als4" value="Waktu pengadaan barang terlalu lama"> <i></i> Waktu pengadaan barang terlalu lama </label>
                        </div>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="als5" id="als5" value="Pengiriman barang terlalu lama"> <i></i> Pengiriman barang terlalu lama </label>
                        </div>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="als6" id="als6" value="Jumlah pesanan tidak sesuai (Kurang/ Lebih)"> <i></i> Jumlah pesanan tidak sesuai (Kurang/ Lebih) </label>
                        </div>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="als7" id="als7" value="Kesalahan Input ke Dolibar"> <i></i> Kesalahan Input ke Dolibar </label>
                        </div>
                        <div class="form-group">
                          <label>Lain-lain :</label>
                          <textarea class="form-control" id="als_ln" name="als_ln" placeholder="lain-lain..."></textarea>
                        </div>
                        <hr>
                      </div>
                      <div class="col-md-12">
                        <h5 class="ibox-titlex">Tindak Lanjut Perubahan PO</h5>
                        <hr>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="pros1" id="pros1" value="cancle"> <i></i> Cancle </label>
                        </div>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="pros2" id="pros2" value="Revisi Invoice"> <i></i> Revisi Invoice </label>
                        </div>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="pros3" id="pros3" value="Lengkapi kekurangan jumlah"> <i></i> Lengkapi kekurangan jumlah </label>
                        </div>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="pros4" id="pros4" value="Tukar SKU yang sama"> <i></i> Tukar SKU yang sama </label>
                        </div>
                        <div class="i-checks">
                          <label> <input type="checkbox" name="pros5" id="pros5" value="Tukar SKU yang berbeda"> <i></i> Tukar SKU yang berbeda </label>
                        </div>
                        <div class="form-group">
                          <label>Lain-lain :</label>
                          <textarea class="form-control" id="pros_ln" name="pros_ln" placeholder="lain-lain..."></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="ibox">
                  <div class="ibox-title">
                    <h5>Catatan :</h5>
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
                    <div class="form-group">
                      <textarea class="form-control" style="height:75px" name="catatan" id="catatan" placeholder="tambahkan catatan disni ..."></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <?php
            $sql_dtl = "SELECT * FROM salesorder_dtl WHERE noso = '$noso'";
            $mwk = $db1->prepare($sql_dtl);
            $mwk -> execute();
            $hsl_dtl= $mwk->get_result();
            $tot = $hsl_dtl->num_rows;
          ?>
          <div class="col-lg-12">
            <div class="ibox">
              <div class="ibox-title">
                <h5>Data PO</h5><small> <em>Ceklis SKU yang mengalami Peruahan</em></small>
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
                <?php $no=0; while($dtl=$hsl_dtl->fetch_assoc()) :$no++; ?>
                <div class="formDetail">
                  <form id="form<?=$no?>">
                    <div class="text-center label label-danger">Item <?=$no?></div>
                    <table class="table-responsive" style="font-size: 0.857em" width="100%">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>SKU</th>
                          <th>Qty</th>
                          <th>Ket</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <input type="checkbox" name="item" id="item<?=$no?>" value="<?php echo $dtl['id']; ?>">
                          </td>
                          <td width="40%"><input type="text" class="form-control" name="sku" id="sku<?=$no?>" value="<?php echo $dtl['model']; ?>" readonly></td>
                          <td width="20%"><input type="text" class="form-control" name="qty" id="qty<?=$no?>" value="<?php echo $dtl['qty']; ?>" readonly style="font-size: 0.856em"></td>
                          <td width="30%"><input type="text" class="form-control" name="ket" id="ket<?=$no?>" value="<?php echo $dtl['keterangan']; ?>"></td>
                        </tr>
                      </tbody>
                    </table>
                    <br>
                  </form>
                </div>
                <?php endwhile; ?>
                <input type="hidden" name="total_row" id="total_row" value="<?=$tot?>">
                <?php if($dt['level'] == 'sales'): ?>
                  <button class="btn btn-success float-right simpan" name="simpan"><span class="glyphicon glyphicon-floppy-disk"></span>
                    Simpan
                  </button>
                <?php endif; ?>
                <button class="btn btn-warning back"><span class="glyphicon glyphicon-arrow-left"></span> Kembali
                </button>
              </div>
            </div>
          </div>
          <?php } ?>
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
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
      $(".back").click(function() {
        window.history.back();
      });
      var value = $('#total_row').val();
      $(".simpan").click(() => {
        var formHdr = $("#formHdr").serializeArray();
        $.ajax({
          method  : "POST",
          url     : "route/fppHdr.php",
          data    : formHdr,
          success: function(data) {
            var idFpp = data;
            for (var i = 1; i <= value; i++) {
              event.preventDefault();
              var tgl = $("#tglfpp").val();
              var form = $('#form' + (i)).serializeArray();
              form.push({
                name: "tgl",
                value: tgl
              });
              form.push({
                name: "idFpp",
                value: idFpp
              });
              form.push({
                name:"no_urut",
                value: i
              });

              $.ajax({
                method    : "POST",
                url       : "route/fppDtl.php",
                data      : form,
                success   : function(data) {
                  // console.log(data);
                }
              });
            }
            var url =
            'https://api.telegram.org/bot1986416343:AAHZjs3Qjh09RzyGWyzrsGkIAC-BYuiKtSc/sendMessage';
            // var chat_id = "1857799344";
            var chat_id = "-1001385335500";
            var text = "Ada Pengajuan Perubahan PO ~ " + 
            " No. FPP : " + idFpp +
            " Diajukan Oleh : " + userinput;
            $.ajax({
              url: url,
              method: "get",
              data: {
                chat_id: chat_id,
                text: text
              }
            });
            Swal.fire(
              'Mantap euy!',
              'Pengajuan berhasil dibuat!',
              'success'
              );
            // console.log(data);
            setTimeout(function() {
              location.assign("myfpp.php");
            }, 2000);
          }
        });
      });
    });
  </script>
</body>
</html>