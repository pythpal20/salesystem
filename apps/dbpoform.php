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

  $ambil_customer ="SELECT * FROM master_customer ORDER BY customer_nama ASC";
  $ambil_perusahaan ="SELECT * FROM list_perusahaan ";
  $hasil_customer = mysqli_query($connect, $ambil_customer);
  $hasil_perusahaan = mysqli_query($connect, $ambil_perusahaan); 
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
          <li>
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
          <li class="active">
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
          <div class="col-lg-12">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Form Input data Order Baru</h5>
                <div class="ibox-tools">
                  <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                  </a>
                  <a class="close-link">
                    <i class="fa fa-times"></i>
                  </a>
                </div>
              </div>
              <input type="hidden" id="lvl" value="<?php echo $data['level']; ?>" >
              <div class="ibox-content">
                <div class="form_header">
                  <form id="formHeader">
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label class="font-normal">Nama Customer</label>
                          <select id="customer" class="form-control chosen-select-karyawan" name="customer" data-placeholder="Pilih Customer ..." tabindex="2" required>
                            <option value="">--Pilih--</option>
                            <?php while($row = mysqli_fetch_array($hasil_customer)) : ?>
                              <option value="<?= $row['customer_id'] ?>"><?=  $row['customer_nama']  ?></option>
                            <?php endwhile ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-offset-2 col-sm-2">
                        <div class="form-group">
                          <label class="font-normal">Status Customer</label>
                          <div class="checkbox">
                            <input type="checkbox" name="statcust" id="statcust" value="new"> NEW
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3">
                        <label class="font-normal">No So Referensi</label>
                        <input type="text" class="form-control" id="nopo_ref" name="nopo_ref">
                      </div>
                      <?php 
                        date_default_timezone_set('Asia/Jakarta');
                        $getwaktu = date('H:i');
                        if ($getwaktu > '14:55') {
                          $tglnow = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
                        } else {
                          $tglnow=date('Y-m-d');
                        }
                      ?>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label class="font-normal">Tanggal Order</label>
                          <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo $tglnow; ?>" 
                          readonly>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Sales</label>
                          <input type="text" name="sales" id="sales" class="form-control" value="<?php echo $data['user_nama']; ?>" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label class="font-normal">Term Of Payment</label>
                          <select id="top" name="top" class="form-control chosen-select-top" required>
                            <option value="">-- Pilih --</option>
                            <option value="Cash On Delivery">Cash On Delivery</option>
                            <option value="Cash Before Delivery">Cash Before Delivery</option>
                            <option value="Transfer">Transfer</option>
                            <option value="TOP 7 Hari">TOP 7 Hari</option>
                            <option value="TOP 14 Hari">TOP 14 Hari</option>
                            <option value="TOP 30 Hari">TOP 30 Hari</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label class="font-normal">Tanggal Kirim</label>
                          <input type="date" id="tglkirim" name="tglkirim" class="form-control"
                          required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label class="font-normal">Jenis Perusahaan</label>
                          <select id="jenisPerusahaan" class="form-control " name="jenisPerusahaan" data-placeholder="Pilih ..." tabindex="2" required>
                            <option value="">--Pilih--</option>
                            <?php while($row_jenis_p = mysqli_fetch_array($hasil_perusahaan)) : ?>
                              <option value="<?= $row_jenis_p['id_perusahaan'] ?>">
                                <?=  $row_jenis_p['nama_pt']  ?>
                              </option>
                            <?php endwhile ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label class="font-normal">Ongkos Kirim</label>
                          <input type="text" name="ongkir" id="ongkir" class="form-control" placeholder="Rp. ">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="font-normal">Alamat Kirim</label>
                          <textarea id="alamatKirim" name="alamatKirim" class="form-control prdalamatKirim" style="height:100px"></textarea>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label class="font-normal">Keterangan</label>
                          <textarea class="form-control" name="keterangan"></textarea>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Form Detail Pesanan</h5>
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
                <div class="main_form">
                  <form id="form1">
                    <div class="text-center label label-danger">Item 1</div>
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>SKU</label>
                          <select name="sku" id="sku1" class="form-control chosen-select1 pilih">
                            <option value="">--Pilih SKU--</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Harga Referensi</label>
                          <input type="text" name="prdHarga" placeholder="Harga Reff" id="prdHarga1" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1">
                        <div class="form-group">
                          <label>Qty</label>
                          <input type="text" class="form-control" placeholder="Qty" name="qty" id="qty1" />
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Harga</label>
                          <input type="text" class="form-control" placeholder="Harga" name="harga" id="harga1" />
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Amount</label>
                          <input type="text" class="form-control" placeholder="amount" name="amount" id="amount1" readonly />
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <div class="form-group">
                          <label>Disc(%)</label>
                          <input type="text" class="form-control" placeholder="%disc" value="0" name="percent_discount" id="percent_discount1" />
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Nom. Disc</label>
                          <input type="text" class="form-control" placeholder="Rp.disc" name="nominal_discount" value="0" id="nominal_discount1" />
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <div class="form-group">
                          <label> </label>
                          <div class="i-checks"><label> <input type="checkbox" id="ppn1" name="ppn" value="10" class="form-control"> <i></i>PPN </label></div>
                          <input type="hidden" name="hitungan_ppn" id="hitungan_ppn1">
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Harga Total</label>
                          <input type="text" class="form-control" placeholder="total" name="harga_total" id="harga_total1" readonly>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label>Keterangan</label>
                          <input type="text" name="ket" class="form-control" placeholder="keterangan" id="ket1">
                        </div>
                      </div>
                    </div>
                    <hr/>
                  </form>
                </div>
              </div>
              <div class="ibox-footer">
                <button class="btn btn-success simpan"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
                <button class="btn btn-primary tambah"><span class="glyphicon glyphicon-plus"></span> Tambah Item</button>
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
  <script src="../js/plugins/select2/select2.full.min.js"></script>
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
        $.ajax({
            url: "route/getSku.php",
            method: "get",
            success: function(data) {
                $('.chosen-select1').select2({

                });
                $('.chosen-select1').append(data);
                $('.chosen-select1').trigger("chosen:updated");
            },
        });

        $("#sku1").change(() => {
            var sku4 = $("#sku1").val();
            $.ajax({
                url: 'route/getPrice.php', // buat file selectData.php terpisah
                method: 'post',
                dataType: "json",
                data: {
                    sku4: sku4
                },
                success: function(data) {
                    console.log(data);
                    $("#prdHarga1").val(data[0]);
                }
            });
        });
        // perhitungan rumus
        $("#harga1").keyup(function() {
            var qty_brg = $("#qty1").val();
            var prc_disc = $("#percent_discount1").val();
            var nmn_disc = $("#nominal_discount1").val();
            var harga_brg = $("#harga1").val();
            var bool_ppn = $("#ppn1").is(':checked');
            var ppn = $("#ppn1").val();
            var harga_ppn = 0;
            var hasil = 0;
            var discount = 0;
            var amount = 0;
            if (bool_ppn) {

                amount = qty_brg * harga_brg;
                discount = nmn_disc;
                harga_ppn = ((qty_brg * harga_brg) - discount) * (10 / 100);

                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
            } else {
                harga_ppn = 0;

                amount = qty_brg * harga_brg;
                discount = nmn_disc;

                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

            }
            $("#hitungan_ppn1").val(harga_ppn);
            $("#amount1").val(amount);
            $("#nominal_discount1").val(discount);
            $("#harga_total1").val(hasil);

        });
        $("#percent_discount1").keyup(function() {
            var qty_brg = $("#qty1").val();
            var prc_disc = $("#percent_discount1").val();
            var nmn_disc = $("#nominal_discount1").val();
            var harga_brg = $("#harga1").val();
            var bool_ppn = $("#ppn1").is(':checked');
            var ppn = $("#ppn1").val();
            var harga_ppn = 0;
            var hasil = 0;
            var amount = 0;
            var discount = 0;
            if (bool_ppn) {

                amount = qty_brg * harga_brg;
                discount = amount * (prc_disc / 100);
                harga_ppn = ((qty_brg * harga_brg) - discount) * (10 / 100);

                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
            } else {
                harga_ppn = 0;

                amount = qty_brg * harga_brg;
                discount = amount * (prc_disc / 100);

                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

            }
            $("#nominal_discount1").val(discount);
            $("#hitungan_ppn1").val(harga_ppn);
            $("#amount1").val(amount);
            $("#harga_total1").val(hasil);
        });
        $("#nominal_discount1").change(function() {
            $("#percent_discount1").val(0);
            $("#qty1").trigger("keyup");
        });
        $("#qty1").keyup(function() {
            var qty_brg = $("#qty1").val();
            var prc_disc = $("#percent_discount1").val();
            var nmn_disc = $("#nominal_discount1").val();
            var harga_brg = $("#harga1").val();
            var bool_ppn = $("#ppn1").is(':checked');
            var ppn = $("#ppn1").val();
            var harga_ppn = 0;
            var hasil = 0;
            var discount = 0;
            var amount = 0;
            if (bool_ppn) {
                amount = qty_brg * harga_brg;
                discount = nmn_disc;
                harga_ppn = ((qty_brg * harga_brg) - discount) * (10 / 100);

                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
            } else {
                harga_ppn = 0;

                amount = qty_brg * harga_brg;
                discount = nmn_disc;

                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

            }
            $("#hitungan_ppn1").val(harga_ppn);
            $("#amount1").val(amount);
            $("#harga_total1").val(hasil);
        });
        $("#ppn1").click(function() {
            var qty_brg = $("#qty1").val();
            var prc_disc = $("#percent_discount1").val();
            var nmn_disc = $("#nominal_discount1").val();
            var harga_brg = $("#harga1").val();
            var bool_ppn = $("#ppn1").is(':checked');
            var ppn = $("#ppn1").val();
            var harga_ppn = 0;
            var hasil = 0;
            var discount = 0;
            var amount = 0;
            if (bool_ppn) {
                amount = qty_brg * harga_brg;
                discount = nmn_disc;
                harga_ppn = ((qty_brg * harga_brg) - discount) * (10 / 100);

                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
            } else {
                harga_ppn = 0;

                amount = qty_brg * harga_brg;
                discount = nmn_disc;

                hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

            }
            $("#hitungan_ppn1").val(harga_ppn);
            $("#amount1").val(amount);
            $("#nominal_discount1").val(discount);
            $("#harga_total1").val(hasil);
        });
        // perhitungan rumus

        $('.chosen-select1').select2({

        });
        $('.chosen-select-karyawan').select2({

        });
        $('.chosen-select-payment').select2({

        });
        $('.chosen-select-top').select2({

        });

        var index = 1;
        $(".tambah").click(function() {
            index++;
            var form = "form" + index;
            var sku = "sku" + index;
            var prdHarga = "prdHarga" + index;
            var qty = "qty" + index;
            var harga = "harga" + index;
            var harga_total = "harga_total" + index;
            var ppn = "ppn" + index;
            var hitungan_ppn = "hitungan_ppn" + index;
            var amount = "amount" + index;
            var percent_discount = "percent_discount" + index;
            var nominal_discount = "nominal_discount" + index;
            var ket = "ket" + index;
            $(".main_form").append('<form id="' + (form) + '">' +
                '<div class="text-center label label label-danger">Item '+index+ '</div><div class="row"> ' +
                '<div class="col-sm-3"><div class="form-group"><label>SKU</label>' +
                '<select  name = "sku' +
                '" id = "' + (sku) + '" class="form-control chosen-select' + index + ' pilih" >' +
                '<option value = "" >--Pilih SKU--</option><div class="dropdown"></div> ' +
                '</select >' +
                '</div></div>' +
                '<div class="col-sm-2"><div class="form-group"><label>Harga Referensi</label>' +
                '<input type = "text"  placeholder="Harga Reff" name ="prdHarga" id = "' + (
                    prdHarga) +
                '" class="form-control" readonly >' +
                '</div></div></div>' +

                '<div class="row"><div class="col-sm-1"><div class="form-group"><label>Qty</label>' +
                '<input type = "text"  placeholder="qty" class="form-control" name = "qty" id = "' +
                (qty) +
                '" / >' +
                '</div></div>' +

                '<div class="col-sm-2"><div class="form-group"><label>Harga</label>' +
                '<input type = "text"  placeholder="Harga" class="form-control" name = "harga" id = "' +
                (harga) + '" / >' +
                '</div></div>' +

                '<div class="col-sm-2"><div class="form-group"><label>Amount</label>' +
                '<input type = "text"  placeholder="amount" class="form-control" name = "amount" id = "' +
                (amount) + '" readonly / >' +
                '</div></div>' +


                '<div class="col-sm-1"><div class="form-group"><label>Disc(%)</label>' +
                '<input type="text" class="form-control" placeholder="%disc" value="0" name="percent_discount" id="' +
                (percent_discount) + '" />' +
                '</div></div>' +
                '<div class="col-sm-2"><div class="form-group"><label>Nom. Disc</label>' +
                '<input type="text" class="form-control" placeholder="Rp.disc" value="0" name="nominal_discount" id="' +
                (nominal_discount) + '" />' +
                '</div></div>' +

                '<div class="col-sm-1"><div class="form-group"><label> </label><div class="i-checks"><label><input type = "checkbox" id = "' +
                ppn +
                '" name = "ppn" value = "10" class="form-control"><i></i>PPN </label></div> <input type="hidden" name="hitungan_ppn" id="' +
                hitungan_ppn + '">' +
                '</div></div>' +
                '<div class="col-sm-2"><div class="form-group"><label>Harga Total</label>' +
                '<input type = "text"  placeholder="total" class="form-control" name ="harga_total" id = "' +
                (harga_total) + '" readonly>' +
                '</div></div>' +

                '<div class="col-sm-2"><div class="form-group"><label>Keterangan</label>' +
                '<input type = "text" placeholder="keterangan" class="form-control" name="ket" id = "' +
                (ket) + '">' +
                '</div></div>' +
                '<hr></div > </form></div></div>');
            //    generate dropdown
            $.ajax({
                url: "route/getSku.php",
                method: "get",
                success: function(data) {
                    // console.log(data);
                    $('.chosen-select' + index).select2({

                    });
                    $('.chosen-select' + index).append(data);
                    $('.chosen-select' + index).trigger("chosen:updated");
                },
            });
            // masukan harga ketika memilih sku ke kolom harga
            for (let i = 1; i <= index; i++) {
                $("#sku" + i).change(() => {
                    var sku4 = $("#sku" + i).val();
                    $.ajax({
                        url: 'route/getPrice.php',
                        method: 'post',
                        dataType: "json",
                        data: {
                            sku4: sku4
                        },
                        success: (data) => {
                            console.log(data);
                            $("#prdHarga" + i).val(data[0]);
                        }
                    });
                });

                // perhitungan rumus
                $("#harga" + i).keyup(function() {
                    var qty_brg = $("#qty" + i).val();
                    var prc_disc = $("#percent_discount" + i).val();
                    var nmn_disc = $("#nominal_discount" + i).val();
                    var harga_brg = $("#harga" + i).val();
                    var bool_ppn = $("#ppn" + i).is(':checked');
                    var ppn = $("#ppn" + i).val();
                    var harga_ppn = 0;
                    var hasil = 0;
                    var discount = 0;
                    var amount = 0;
                    if (bool_ppn) {
                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;
                        harga_ppn = ((qty_brg * harga_brg) - discount) * (10 / 100);

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    } else {
                        harga_ppn = 0;

                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                    }
                    $("#hitungan_ppn" + i).val(harga_ppn);
                    $("#amount" + i).val(amount);
                    $("#harga_total" + i).val(hasil);
                    $("#nominal_discount" + i).val(discount);
                });
                $("#percent_discount" + i).keyup(function() {
                    var qty_brg = $("#qty" + i).val();
                    var prc_disc = $("#percent_discount" + i).val();
                    var nmn_disc = $("#nominal_discount" + i).val();
                    var harga_brg = $("#harga" + i).val();
                    var bool_ppn = $("#ppn" + i).is(':checked');
                    var ppn = $("#ppn" + i).val();
                    var harga_ppn = 0;
                    var hasil = 0;
                    var amount = 0;
                    var discount = 0;
                    if (bool_ppn) {
                        amount = qty_brg * harga_brg;
                        discount = amount * (prc_disc / 100);
                        harga_ppn = ((qty_brg * harga_brg) - discount) * (10 / 100);

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    } else {
                        harga_ppn = 0;

                        amount = qty_brg * harga_brg;
                        discount = amount * (prc_disc / 100);

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                    }
                    $("#nominal_discount" + i).val(discount);
                    $("#hitungan_ppn" + i).val(harga_ppn);
                    $("#amount" + i).val(amount);
                    $("#harga_total" + i).val(hasil);
                });
                $("#nominal_discount" + i).change(function() {
                    $("#percent_discount" + i).val(0);
                    $("#qty" + i).trigger("keyup");
                });
                $("#qty" + i).keyup(function() {
                    var qty_brg = $("#qty" + i).val();
                    var prc_disc = $("#percent_discount" + i).val();
                    var nmn_disc = $("#nominal_discount" + i).val();
                    var harga_brg = $("#harga" + i).val();
                    var bool_ppn = $("#ppn" + i).is(':checked');
                    var ppn = $("#ppn" + i).val();
                    var harga_ppn = 0;
                    var hasil = 0;
                    var discount = 0;
                    var amount = 0;
                    if (bool_ppn) {

                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;
                        harga_ppn = ((qty_brg * harga_brg) - discount) * (10 / 100);

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    } else {
                        harga_ppn = 0;

                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                    }
                    $("#hitungan_ppn" + i).val(harga_ppn);
                    $("#amount" + i).val(amount);
                    $("#harga_total" + i).val(hasil);
                    $("#nominal_discount" + i).val(discount);
                });
                $("#ppn" + i).click(function() {
                    var qty_brg = $("#qty" + i).val();
                    var prc_disc = $("#percent_discount" + i).val();
                    var nmn_disc = $("#nominal_discount" + i).val();
                    var harga_brg = $("#harga" + i).val();
                    var bool_ppn = $("#ppn" + i).is(':checked');
                    var ppn = $("#ppn" + i).val();
                    var harga_ppn = 0;
                    var hasil = 0;
                    var discount = 0;
                    var amount = 0;
                    if (bool_ppn) {
                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;
                        harga_ppn = ((qty_brg * harga_brg) - discount) * (10 / 100);

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;
                    } else {
                        harga_ppn = 0;

                        amount = qty_brg * harga_brg;
                        discount = nmn_disc;

                        hasil = ((qty_brg * harga_brg) - discount) + harga_ppn;

                    }
                    $("#hitungan_ppn" + i).val(harga_ppn);
                    $("#amount" + i).val(amount);
                    $("#harga_total" + i).val(hasil);
                    $("#nominal_discount" + i).val(discount);
                });
                // perhitungan rumus

            }

        });
        $(".simpan").click(() => {
            //kirim ke detail
            var formHeader = $("#formHeader").serializeArray();
            // alert($("input[name=nopo]").val());
            var u_input = $('#sales').val();
            var customer = $('#customer').val();
            var tgl = $('#tanggal').val();
            var alamat_kirim = $('#alamatKirim').val();
            var jenis_perusahaan = $('#jenisPerusahaan').val();
            if (customer == '' || tgl == '' || alamat_kirim == '' || jenis_perusahaan == '') {
                alert('Tolong input PO dengan lengkap!');
            } else {
                // kirim ke header
                $.ajax({
                    method: "POST",
                    url: "so_hdr.php",
                    data: formHeader,
                    success: function(data) {
                        var id_po = data;
                        console.log(id_po);
                        for (var i = 1; i <= index; i++) {
                            // event.preventDefault();
                            // declare form
                            var tgl = $("#tanggal").val();
                            var form = $('#form' + (i)).serializeArray();
                            form.push({
                                name: "tgl",
                                value: tgl
                            });
                            form.push({
                                name: "nopo",
                                value: id_po
                            });
                            form.push({
                                name: "no_urut",
                                value: i
                            });
                            console.log(form);
                            $.ajax({
                                method: "POST",
                                url: "so_dtl.php",
                                data: form,
                                success: function(data) {
                                    console.log(data);

                                }
                            });
                        }
                        alert("data berhasil ditambah");
                        var url =
                  'https://api.telegram.org/bot1874545494:AAHrh4MvIxSn_MgLhdtlaU2Zpdcdq6ERf0w/sendMessage';
                        // var chat_id = "1857799344";
                        var chat_id = "-1001385335500";
                        var text = "Ada Data PO baru ~ " + 
                        " No. Sales Order : " + id_po +
                        " Nama Sales : " + u_input + " | Produk : " + index +" SKU, " + " Customer : " + customer ;
                        $.ajax({
                            url: url,
                            method: "get",
                            data: {
                            chat_id: chat_id,
                            text: text
                            }
                        });
                        setTimeout(function() {
                          // your code to be executed after 1 second
                          var lvl = $('#lvl').val();
                          if(lvl !== "sales") {
                            location.assign(
                              "dbpurchaseorder.php");
                          } else {
                            location.assign(
                              "dataposales.php");
                          }
                        },
                      2000);
                    }
                });
            }
        });


    });
    </script>
    <script type="text/javascript">
    $('#customer').change(function() {
        var idcust = $("#customer").val();
        $.ajax({
            url: 'route/ambilAlamat.php',
            method: 'post',
            dataType: 'json',
            data: {
                idcust: idcust
            },
            success: function(data) {
                // console.log(data);
                var reslt = data;
                $('#alamatKirim').val(reslt.alamat);
            }
        });
    });
    </script>
  </body>
  </html>

