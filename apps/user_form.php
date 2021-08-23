 <script>
  $('#update_form').on("submit", function(event){  
    event.preventDefault(); 
    $.ajax({
      url:"user_update.php",  
      method:"POST",  
      data : $('#update_form').serialize(),  
      beforeSend:function(){  
        $('#update').val("Updating");  
      },  
      success:function(data){ 
        $('#update_form')[0].reset();  
        $('#editModal').modal('hide'); 
        window.location.reload(); 
      } 
    });
  });
</script>
<?php 
if(isset($_POST["iduser"]))
{
  $output = '';
  //$connect = mysqli_connect("localhost", "root", "", "input_karyawan");
  include 'route/config.php';
  $query = "SELECT * FROM master_user WHERE user_id = '".$_POST["iduser"]."'";
  $mwk = $db1->prepare($query);
  $mwk -> execute();
  $res1 = $mwk->get_result();
  $row = $res1->fetch_assoc();
  $output .= '
    <form method="post" id="update_form">
      <label>Nama User</label>
      <input type="hidden" name="id" id="id" value="'.$_POST["iduser"].'" class="form-control" />
      <input type="text" name="nama" id="nama" value="'.$row["user_nama"].'" class="form-control" />
      <br />
      <label>Username</label>
      <input type="text" name="username" id="username" class="form-control" value="'.$row["username"].'">
      <br />
      <label>Password</label>
      <input type="password" name="pass" id="pass" class="form-control" >
      <br>
      <label>Level</label>
      <select name="lvl" id="lvl" class="form-control" >';
        if($row['level']=="admin"){
          $output .= '<option value="admin" selected>Admin</option>  
          <option value="superadmin">Super Admin</option>
          <option value="sales">Sales</option>';
        }elseif($row['level']=="superadmin") {
          $output .= '<option value="superadmin" selected>Super Admin</option>  
          <option value="admin" >Admin</option>
          <option value="sales">Sales</option>';
        }elseif($row['level']=="sales") {
          $output .= '<option value="sales" selected>Sales</option>
          <option value="superadmin">Super Admin</option>  
          <option value="admin" >Admin</option>';
        }else{
          $output .= '
          <option value="superadmin">Super Admin</option>
          <option value="admin" >Admin</option>
          <option value="sales">Sales</option>';
        }
        $output .= '</select>
        <br />
        <input type="submit" name="update" id="update" value="Update" class="btn btn-success" />

    </form>
     ';
    echo $output;
}
?>
