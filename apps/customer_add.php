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
          <div class="col-lg-12">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Form tambah Customer</h5>
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
                <form method="POST" id="insert_form">
                  <div class="row">
                    <input type="hidden" name="inputby" id="inputby" value="<?php echo $data['user_nama']; ?>">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label>Nama Customer</label>
                        <input type="text" name="nama_customer" id="nama_customer" class="form-control" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Kategori Customer</label>
                        <select name="kategori" id="kategori" class="form-control" required="">
                          <option value="">= Pilih Kategori =</option>
                          <?php
                            $sql = "SELECT * FROM master_kategori ORDER BY kategori_nama";
                            $mwk = $db1->prepare($sql);
                            $mwk->execute();
                            $resl = $mwk->get_result();
                            while ($ct=$resl->fetch_assoc()){
                              echo '<option value="'.$ct['kategori_nama'].'">'.$ct['kategori_nama'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <input type="hidden" name="kode_kategori" id="kodeKat">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Telp.</label>
                        <input type="text" name="telp" class="form-control" placeholder="No. telp">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Provinsi</label>
                        <select id="prov" name="prov" class="form-control selectProv" required="">
                          <option value="">Pilih Provinsi</option>
                          <?php
                            $provinsi = "SELECT wilayah_id, wilayah_nama FROM master_wilayah WHERE CHAR_LENGTH(wilayah_id)=2 ORDER BY wilayah_id";
                            $mwk = $db1->prepare($provinsi);
                            $mwk->execute();
                            $resl = $mwk->get_result();
                            while($pv=$resl->fetch_assoc()){
                              echo '<option value="'.$pv['wilayah_id'].'">'.$pv['wilayah_nama'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Kabupaten/Kota</label>
                        <select name="kab" id="kab" class="form-control selectKab" required="">
                          <option value="">Kabupaten/kota</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label>Alamat Customer</label>
                        <textarea class="form-control" name="almtCustomer" id="almtCustomer" required=""></textarea>
                      </div>
                    </div>
                    <input type="hidden" name="kode_wilayah" id="kodeWil">
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Pemilik/PIC/Penanggung Jawab</label>
                        <input type="text" name="pic" id="pic" class="form-control" placeholder="Nama PIC" required="">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Hp/ Telp (PIC)</label>
                        <input type="text" name="kontak" id="kontak" class="form-control" required="">
                      </div>
                    </div>
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label>Alamat PIC</label>
                        <textarea class="form-control" name="almtPic" id="almtPic" placeholder="alamat penanggung jawab"></textarea>
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-danger back"><span class="glyphicon glyphicon-arrow-left"></span> Batal</button>
                  <button class="btn btn-success simpan"><span class="fa fa-save (alias)"></span> Simpan</button>
                </form>
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
  <script type="text/javascript">
    $(document).ready(function(){
      $(".back").click(function() {
        window.history.back();
      });
      // sembunyikan form kabupaten, kecamatan dan desa
      $("#kab").hide();
      $('.selectProv').select2();
      // ambil data kabupaten ketika data memilih provinsi
      $('body').on("change","#prov",function(){
        var id = $(this).val();
        var data = "id="+id+"&data=kabupaten";
        $.ajax({
          type: 'POST',
          url: "route/getKab.php",
          data: data,
          success: function(hasil) {
            $("#kab").html(hasil);
            $('.selectKab').select2();
            $("#kab").show();
            // console.log(hasil);
          }
        });
      });
      $("#kategori").change(() => {
        var idKat = $("#kategori").val();
        // console.log(idKat);
        $.ajax({
          url: 'route/getKodeKat.php',
          method: 'post',
          dataType: "json",
          data: {
            idKat: idKat
          },
          success: (data) => {
            // console.log(data);
            $("#kodeKat").val(data);
          }
        });
      });
      $("#kab").change(() => {
        var idKab = $("#kab").val();
        // console.log(idKab);
        $.ajax({
          url: 'route/getKodeKab.php',
          method: 'post',
          dataType: "json",
          data: {
            idKab: idKab
          },
          success: (data) => {
            // console.log(data);
            $("#kodeWil").val(data);
          }
        });
      });
      $('#insert_form').on("submit", function(event){
        event.preventDefault();
        $.ajax({  
          url:"route/customerAdd.php",  
          method:"POST",  
          data:$('#insert_form').serialize(),
          beforeSend:function(){  
            $('#insert').val("Inserting"); 
          }, 
          success:function(data){ 
            // console.log(data);
            Swal.fire(data);
            setTimeout(function() {
              // your code to be executed after 1 second
              var lvl = $('#lvl').val();
              if(lvl !== "sales") {
                  location.assign(
                  "customer.php");
              } else {
                location.assign(
                "csBysales.php");
              }
            },
            2000);
          }
        });
      });
    });
  </script>
</body>
</html>