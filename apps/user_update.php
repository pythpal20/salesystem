<?php
 
include 'route/config.php';
if(!empty($_POST))
{
 $output = '';
    $nama = mysqli_real_escape_string($connect, $_POST["nama"]);  
    $username = mysqli_real_escape_string($connect, $_POST["username"]);  
    $pass = mysqli_real_escape_string($connect, $_POST["pass"]);
    $level = mysqli_real_escape_string($connect, $_POST["lvl"]);
    $query = "
    UPDATE master_user SET user_nama = '$nama', username = '$username', password =md5('$pass'), level='$level' WHERE user_id = '$_POST[id]'
    ";
    
    if(mysqli_query($connect, $query)) 
    {
        $output .= '<script>alert("Update Data Berhasil");</script>';
    } else{
        $output .= mysqli_error($connect);
    }
    echo $output;
}
?>