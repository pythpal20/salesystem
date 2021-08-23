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
      include 'route/config.php';
      $ambil_perusahaan ="SELECT * from list_perusahaan ";
      $query = "SELECT * FROM salesorder_dtl WHERE noso='".$_GET['id']."'";
      $header =  "SELECT * FROM salesorder_hdr WHERE noso='".$_GET['id']."'";
      $ambil_customer ="SELECT * from master_customer where customer_idregister !=''";

      $result = mysqli_query($connect,$query);
      $result_header = mysqli_query($connect,$header);
      $hasil_customer = mysqli_query($connect, $ambil_customer);
      $hasil_perusahaan = mysqli_query($connect, $ambil_perusahaan);

      $total_row = mysqli_num_rows($result);
      function cari_nama_customer($id){
        include 'route/config.php';
        $query = "SELECT customer_nama FROM master_customer WHERE customer_id='$id'";
        $result = mysqli_query($connect,$query);
        $arr ="";
        while ($row = mysqli_fetch_array($result)) {
            # code...
          $arr =  $row['customer_nama'];
        }
        return $arr;
      }

      function cari_customer_nama($id){
        include 'route/config.php';
        $query = "SELECT * FROM list_perusahaan WHERE id_perusahaan='$id'";
        $result = mysqli_query($connect,$query);
        $arr ="";
        while ($row = mysqli_fetch_array($result)) {
            # code...
          $arr =  $row['nama_pt'];
        }
        return $arr;
      }
      ?>
      <?php while ($item = mysqli_fetch_array($result_header)) : ?>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox">
              <div class="ibox-title">
                <h5>Form Edit data Order Baru</h5>
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
                <div class="form_header">
                  <form id="formHeader">
                    <div class="row">
                      <div class="col-sm-3"> <!-- nama customer -->
                        <div class="form-group">
                          <input name="nopo" type="hidden" value="<?=$noso?>">
                          <label class="font-normal">Nama Customer</label>
                          <select id="customer" class="form-control chosen-select-karyawan" name="customer" data-placeholder="Pilih Konsumen ..." tabindex="2" required>
                            <option value="<?=$item['customer_id']?>">
                              <?=cari_nama_customer($item['customer_id'])?>
                            </option>
                            <?php while($row = mysqli_fetch_array($hasil_customer)) : ?>
                              <option value="<?= $row['customer_id'] ?>">
                                <?=  $row['customer_nama']  ?>
                              </option>
                            <?php endwhile ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3"> <!--  -->
                        <div class="form-group">
                          <label class="font-normal">Nopo Referensi</label>
                          <input type="text" class="form-control" id="nopo_ref" name="nopo_ref" value="<?=$item['noso_ref']?>">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label class="font-normal">Tanggal Order</label>
                          <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?=$item['tgl_po']?>" readonly>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label>Sales</label>
                          <input type="text" value="<?=$item['sales']?>" name="sales" id="sales"
                          class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label class="font-normal">Tanggal Kirim</label>
                          <input type="date" id="tglkirim" name="tglkirim" class="form-control"
                          required="" value="<?=$item['tgl_krm']?>">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label class="font-normal">Term Of Payment</label>
                          <select id="top" name="top" class="form-control chosen-select-top">
                            <option value="<?=$item['term']?>"><?=$item['term']?></option>
                            <option value="Cash On Delivery">Cash On Delivery</option>
                            <option value="Cash Before Delivery">Cash Before Delivery</option>
                            <option value="Transfer">Transfer</option>
                            <option value="TOP 7 Hari">TOP 7 Hari</option>
                            <option value="TOP 14 Hari">TOP 14 Hari</option>
                            <option value="TOP 30 Hari">TOP 30 Hari</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label class="font-normal">Jenis Perusahaan</label>
                          <select id="jenisPerusahaan" class="form-control " name="jenisPerusahaan"
                          data-placeholder="Pilih ..." tabindex="2" required>
                          <option value="<?=$item['id_perusahaan']?>">
                            <?=cari_customer_nama($item['id_perusahaan'])?></option>
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
                          <input type="text" name="ongkir" id="ongkir" class="form-control"
                          placeholder="Rp. " value="<?=$item['ongkir']?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <label class="font-normal">Alamat Kirim </label> (alternatif)
                          <textarea id="alamatKirim" name="alamatKirim" style="height:75px" class="form-control prdalamatKirim"><?=$item['alamat_krm']?></textarea>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label class="font-normal">Keterangan</label>
                          <textarea class="form-control"
                          name="keterangan"><?=$item['keterangan']?></textarea>
                        </div>
                      </div>
                    </div>
                    <?php endwhile; ?>
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
                <?php $no=0;while ($detail_item = mysqli_fetch_array($result)) :$no++;?>
                <div class="main_form">
                  <form id="form<?=$no?>">
                    <div class="table-responsive">
                    <table class="table" width="100%">
                      <thead>
                        <tr class="text-center ">
                          <th>SKU</th>
                          <th> Harga Reff</th>
                          <th>Qty</th>
                          <th>Harga</th>
                          <th>amount</th>
                          <th>Disc(%)</th>
                          <th>Disc(Rp.)</th>
                          <th style="vertical-align:middle;">PPN</th>
                          <th>Total</th>
                          <th>Ket</th>
                        </tr>
                      </thead>
                      <tbody>
                        <input name="nopo" type="hidden" value="<?=$noso?>">
                        <input type="hidden" name="iditem" value="<?php echo $detail_item['id']; ?>">
                        <tr>
                          <td width="22%">
                            <select name="sku" id="sku<?=$no?>" class="form-control chosen-select-sku pilih">
                              <option value="<?=$detail_item['model']?>">
                                <?=$detail_item['model']?>
                              </option>
                            </select>
                          </td>
                          <td width="95px">
                            <input type="text" name="prdHarga" placeholder="Harga Reff"
                            value="<?=$detail_item['harga_ref']?>"
                            id="prdHarga<?=$no?>" class="form-control" readonly>
                          </td>
                          <td width="80px">
                            <input type="text" class="form-control" placeholder="Qty"
                            name="qty" id="qty<?=$no?>"
                            value="<?=$detail_item['qty']?>" />
                          </td>
                          <td width="95px">
                            <input type="text" class="form-control" placeholder="Harga"
                            name="harga" id="harga<?=$no?>"
                            value="<?=$detail_item['price']?>" />
                          </td>
                          <td width="100px">
                            <input type="text" class="form-control" placeholder="amount"
                            name="amount" id="amount<?=$no?>"
                            value="<?=$detail_item['amount']?>" readonly />
                          </td>
                          <td width="15px">
                            <input type="text" class="form-control" placeholder="%disc"
                            value="0" name="percent_discount"
                            id="percent_discount<?=$no?>" />
                          </td>
                          <td width="95px">
                            <input type="text" class="form-control"
                            placeholder="Rp.disc" name="nominal_discount"
                            value="<?=$detail_item['diskon']?>"
                            id="nominal_discount<?=$no?>" />
                          </td>
                          <td>
                            <input type="checkbox" id="ppn<?=$no?>" name="ppn"
                            value="10"
                            <?php if($detail_item['ppn'] != "0"): echo "checked"; endif;?>>
                            <input type="hidden" name="hitungan_ppn"
                            id="hitungan_ppn<?=$no?>" value = "<?php echo $detail_item['ppn']; ?>">
                            PPN
                          </td>
                          <td width="100px">
                            <input type="text" class="form-control" placeholder="total"
                            name="harga_total" id="harga_total<?=$no?>"
                            value="<?=$detail_item['harga_total']?>" readonly>
                          </td>
                          <td width="120px">
                            <input type="text" name="ket" class="form-control"
                            placeholder="keterangan" id="ket<?=$no?>"
                            value="<?=$detail_item['keterangan']?>">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    </div>
                  </form>
                </div>
                <?php endwhile; ?>
                <input type="hidden" name="total_row" id="total_row" value="<?=$total_row?>">
                <?php if($dt['level'] !== 'sales'): ?>
                  <button class="btn btn-success float-right simpan"><span class="glyphicon glyphicon-floppy-disk"></span>
                    Simpan
                  </button>
                <?php endif; ?>
                <button class="btn btn-warning back"><span class="glyphicon glyphicon-arrow-left"></span> Kembali
                </button>
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
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    $(".back").click(function() {
      window.history.back();
    });
  </script>
  <script>
    $(document).ready(function() {
      $('.chosen-select-karyawan').select2();
      var value = $('#total_row').val();
      $.ajax({
        url: "route/getSku.php",
        method: "get",
        success: function(data) {
          $('.chosen-select-sku').select2({

          });
          $('.chosen-select-sku').append(data);
          $('.chosen-select-sku').trigger("chosen:updated");
        },
      });
      // perumusan
      for (let i = 0; i <= value; i++) {
        $("#sku" + i).change(() => {
          var sku4 = $("#sku" + i).val();
          $.ajax({
            url: 'route/getPrice.php', // buat file selectData.php terpisah
            method: 'post',
            dataType: "json",
            data: {
              sku4: sku4
            },
            success: function(data) {
              console.log(data);
              $("#prdHarga" + i).val(data[0]);
            }
          });
        });
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
      }
      $(".simpan").click(() => {
        //kirim ke detail
        var formHeader = $("#formHeader").serializeArray();
        console.log(formHeader);
        // alert($("input[name=nopo]").val());
        var customer = $('#customer').val();
        var tgl = $('#tanggal').val();
        var top = $('#top').val();
        var payment = $('#payment').val();
        var tgl_kirim = $('#tglKirim').val();
        var alamat_kirim = $('#alamatKirim').val();
        var jenis_perusahaan = $('#jenisPerusahaan').val();

        if (customer == '' || tgl == '' || top == '' || payment == '' || tgl_kirim == '' ||
          alamat_kirim == '' || jenis_perusahaan == '') {
          alert('Tolong input PO dengan lengkap!');
      } else {
        // kirim ke header
        $.ajax({
          method: "POST",
          url: "update_hdr.php",
          data: formHeader,
          success: function(data) {
          // console.log(data);
            // console.log(formHeader);
          }
        });
        // console.log("header" + ":" + formHeader);
        for (var i = 1; i <= value; i++) {
          event.preventDefault();
          // declare form
          var tgl = $("#tanggal").val();
          var form = $('#form' + (i)).serializeArray();
          form.push({
            name: "tgl",
            value: tgl
          });
          console.log(form);
          $.ajax({
            method: "POST",
            url: "update_dtl.php",
            data: form,
            success: function(data) {
              // console.log(data);
            }
          });
        }
        alert("Update Berhasil, Horee!");
        setTimeout(function() {
          // your code to be executed after 1 second
          location.assign(
          "dbpurchaseorder.php");
        },
        2000);
      }
    });
    });
  </script>
</body>
</html>