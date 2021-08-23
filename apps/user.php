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
  <link href="../css/plugins/datapicker/datepicker3.css" rel="stylesheet">
  <link href="../css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
  <link href="../css/plugins/footable/footable.core.css" rel="stylesheet">
  <link href="../css/plugins/footable/footable.paging.css" rel="stylesheet">
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
              <div style="height: 30px;
              width: 30px;
              background-color: #dd0000;
              border-radius: 50%;
              display: inline-block;">
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
          <li class="active">
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
            <?php if($data['level'] !== 'sales') : ?>
            <button type="button" name="usr" id="usr" data-toggle="modal" data-target="#add_data_Modal"  class="btn btn-info"><span class="fa fa-plus-circle"></span> Tambah User</button>
            <?php endif ?>
          </div>
          <div class="col-lg-12">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Data Pengguna</h5>
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
                  <div class="col-sm-12 m-b-xs">
                    <input type="text" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Ketik disini untuk mencari data. . .">
                  </div>
                </div>
                <div class="">
                  <table class="table footable table-bordered table-hover" data-page-size="10" data-filter=#filter data-first-text="FIRST" data-NEXT-text="NEXT" data-previous-text="PREVIOUS" data-last-text="LAST">
                    <thead scoop="row">
                      <tr>
                        <th>#</th>
                        <th>Nama User</th>
                        <th data-hide="phone">No. Hp/Telp</th>
                        <th data-hide="phone">Email</th>
                        <th data-hide="phone">Compani</th>
                        <th data-hide="phone">Level</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $no = 1;
                        $user_list = "SELECT * FROM master_user";
                        $mwk = $db1->prepare($user_list);
                        $mwk -> execute();
                        $reslt = $mwk->get_result();
                        if ($reslt->num_rows>0){
                          while ($row = $reslt->fetch_array()) {
                            # code...
                      ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['user_nama']; ?></td>
                        <td><?php echo $row['notelp']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['company']; ?></td>
                        <td><?php echo $row['level']; ?></td>
                        <?php if($data['level'] !=='sales') : ?>
                          <td>
                            <button type="button" name="edit" id="<?php echo $row['user_id']; ?>" class=" btn btn-primary btn-xs edit_data" title="Ubah Data" rel="tooltip"><span class="fa fa-edit (alias)"></span> </button>
                            <a href="#myModal" class="trash btn btn-xs btn-danger" title="Hapus" rel="tooltip" data-id="<?php echo $row['user_id']; ?>" role="button" data-toggle="modal"><span class="fa fa-trash"></span></a>
                          </td>
                        <?php endif; ?>
                      </tr>
                      <?php
                          }
                        }
                      ?>
                    </tbody>
                    <tfoot class="hide-if-no-paging">
                      <tr>
                        <td colspan="7">
                          <ul class="pagination float-right"></ul>
                        </td>
                      </tr>
                    </tfoot>
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
  <script src="../js/inspinia.js"></script>
  <script src="../js/plugins/pace/pace.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- FooTable -->
  <script src="../js/plugins/footable/footable.all.min.js"></script>
  <script src="../js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
  <script src="../js/plugins/flot/jquery.flot.js"></script>
  <script src="../js/plugins/flot/jquery.flot.tooltip.min.js"></script>
  <script src="../js/plugins/flot/jquery.flot.spline.js"></script>
  <script src="../js/plugins/flot/jquery.flot.resize.js"></script>
  <script src="../js/plugins/flot/jquery.flot.pie.js"></script>
  <script>
    $(document).ready(function(){
      $('.footable').footable({
        "paging" : {
          "limit" : 5
        }
      });
    });
  </script>
  <script>
    $(document).on('click','.trash',function(){
      var id = $(this).attr('data-id');
      $.ajax({
        method: "POST",
        url: "deleteuser.php",
        data:{id:id},
        success:function(data){
          Swal.fire(data);
          setTimeout(function() {
            // your code to be executed after 1 second
            location.assign(
              "user.php");
          },
          2000);
        }
      });
    });
  </script>
</body>
</html>
<div id="add_data_Modal" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <?php
        $ambil = "SELECT MAX(user_id) as idArr FROM master_user";
        $mwk = $db1->prepare($ambil);
        $mwk -> execute();
        $res1 = $mwk->get_result();
        while ($sb = $res1->fetch_assoc()) {
          $IdUser  = $sb['idArr'];
          $urutan = (int) substr($IdUser, 3, 3);
          $urutan++;
          $huruf = "SO";
          $IdUser = $huruf ."-". sprintf("%03s", $urutan);
        }
      ?>
      <div class="modal-body" id="add_data_Modal">
        <div class="container">
          <form method="post" id="insert_form">
            <input type="hidden" name="iduser" id="iduser" class="form-control" value="<?php echo $IdUser; ?>" readonly>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Nama User</label>
                  <input type="text" name="nama" id="nama" class="form-control" required="" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>No. HP/Telp</label>
                  <input type="text" name="kontak" id="kontak" class="form-control" required="" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" id="email" class="form-control" required="" placeholder="nama @ domain">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Username</label>
                  <input type="text" name="username" id="username" class="form-control" required="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Password</label>
                  <input type="password" name="password" id="password" class="form-control" required="" placeholder="******">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Company</label>
                  <select class="form-control" name="comm" id="comm" required="">
                    <option value="">Pilih Company</option>
                    <option value="Foodpack">Foodpack</option>
                    <option value="Mr.Kitchen">Mr. Kitchen</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Level User</label>
                  <select class="form-control" name="level" id="level" required="">
                    <option value="">Pilih Level</option>
                    <?php if ($data['level'] == 'superadmin') : ?>
                      <option value="superadmin">Super Admin</option>
                    <?php endif ?>
                    <option value="admin">Admin</option>
                    <option value="sales">Sales</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group row">
              <div class="col-sm-4">
                <button class="btn btn-primary" id="submit" type="submit"><span class="fa fa-check"></span> Simpan</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-window-close"></span> Close</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="editModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Data User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="form_edit">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
      $('#insert_form').on("submit", function(event){  
        event.preventDefault();  
        $.ajax({  
          url:"user_add.php",  
          method:"POST",  
          data:$('#insert_form').serialize(),  
          beforeSend:function(){  
            $('#insert').val("Inserting"); 
          }, 
          success:function(data){  
            $('#insert_form')[0].reset();  
            $('#add_data_Modal').modal('hide');
            // console.log(data);
            Swal.fire(data);
            setTimeout(function() {
              // your code to be executed after 1 second
              location.assign(
                "user.php");
            },
            2000);
          }  
        }); 
      });

      $(document).on('click', '.edit_data', function(){
        var iduser = $(this).attr("id");
        $.ajax({
          url:"user_form.php",
          method:"POST",
          data:{iduser:iduser},
          success:function(data){
            $('#form_edit').html(data);
            $('#editModal').modal('show');
          }
        });
      });

    });
</script>
