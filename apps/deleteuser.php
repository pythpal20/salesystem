<?php
// SQL hapus
	error_reporting(0);
	include 'route/config.php';
	$id = $_POST['id'];
	$query="DELETE FROM master_user WHERE user_id='$id'";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$res1 = $mwk->get_result();
    // jika gagal
    if ($res1->num_rows > 0){
    	echo $db1->error;
    } else {
    	echo "OK, User berhasil dihapus..";
    }
?>