<?php
    error_reporting(0);
    include 'route/config.php';
    if(!empty($_POST)) {
        $output = '';
        $id = mysqli_real_escape_string($connect, $_POST["iduser"]);  
        $nama = mysqli_real_escape_string($connect, $_POST["nama"]);  
        $username = mysqli_real_escape_string($connect, $_POST["username"]);  
        $pass = mysqli_real_escape_string($connect, $_POST["password"]);
        $level = mysqli_real_escape_string($connect, $_POST["level"]);
        $kontak = $_POST['kontak'];
        $email = $_POST['email'];
        $comm = $_POST['comm'];
        // var_dump($_POST); die;

        // cek data dulu yuk
        $cek ="SELECT * FROM master_user WHERE user_nama = '$nama' AND level = '$level'";
        $mwk = $db1->prepare($cek);
        $mwk->execute();
        $result = $mwk->get_result();
        if($result->num_rows > 0){
            echo 'Data dengan nama <b>'.$nama.'</b> dan level '.$level.' sudah ada !';
        } else{
            $query = "INSERT INTO master_user (user_id, user_nama, username, password, level, notelp, email, company) VALUES('$id', '$nama', '$username', md5('$pass'), '$level', '$kontak', '$email', '$comm')";
            $mwk = $db1->prepare($query);
            $mwk->execute();
            $resl=$mwk->get_result();
            if($resl->num_rows > 0){
                echo $db1->error;
            } else {
                echo 'Yeay ! Data berhasil disimpan...';
            }
        }
    }
?>