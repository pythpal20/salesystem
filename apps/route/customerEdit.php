<?php
	error_reporting(0);
	include 'config.php';
	$id_customer = $_POST['idc'];
	$id_register = $_POST['idRegister'];
	$tglNow = date('Y-m-d');
	$user = $_POST['inputby'];
	$nm_customer = $_POST['nama_customer'];
	$cs_kategori = $_POST['kategori'];
	$cs_telp = $_POST['telp'];
	$id_prov = $_POST['prov'];
	$id_kota = $_POST['kab'];
	$cs_alamat = $_POST['almtCustomer'];
	$pic = $_POST['pic'];
	$pic_kontak = $_POST['kontak'];
	$pic_alamat = $_POST['almtPic'];
	// var_dump($_POST); die();
	$cd_kategori = $_POST['kode_kategori'];
	$cd_wilayah = $_POST['kode_wilayah'];
	// generate id register
	$cekTgl = date('ymd');
	$ambiNo = "SELECT MAX(customer_idregister) AS idArr FROM master_customer WHERE customer_kategori='$cs_kategori' AND customer_kota = '$id_kota'";
	$mwk = $db1->prepare($ambiNo);
	$mwk -> execute();
	$resl = $mwk->get_result();
	while ($sb = $resl->fetch_assoc()) {
		$idRegister  = $sb['idArr'];
		$urutan = (int) substr($idRegister, 14, 14);
		$urutan++;
		$huruf = $_POST['kode_wilayah'].".".$_POST['kode_kategori'];
		$idRegister = $huruf.".".$cekTgl.".".sprintf("%05s", $urutan);
		// var_dump($sb['idArr']);
	}
	// die();
	$cek = "SELECT * FROM master_customer WHERE customer_idregister = '$id_register'";
	$mwk = $db1->prepare($cek);
	$mwk -> execute();
	$reslc = $mwk->get_result();
	if ($reslc->num_rows > 0){
		$update1 = "UPDATE master_customer SET customer_nama = '$nm_customer', customer_kategori = '$cs_kategori', customer_provinsi = '$id_prov', customer_kota = '$id_kota', customer_alamat = '$cs_alamat', customer_telp = '', pic_nama = '$pic', pic_alamat = '$pic_alamat', pic_kontak = '$pic_kontak' WHERE customer_id = '$id_customer'";
		$mwk = $db1->prepare($update1);
		$mwk -> execute();
		$reslu = $mwk->get_result();
		if ($reslu->num_rows > 0) {
			echo 'Gagal Query! silahkan coba lagi :)';
		} else {
			echo 'Update Data Berhasil';
		}
	} else{
		$query_insert = "UPDATE master_customer SET customer_idregister= '$idRegister', customer_nama = '$nm_customer', customer_kategori = '$cs_kategori', customer_provinsi = '$id_prov', customer_kota = '$id_kota', customer_alamat = '$cs_alamat', customer_telp = '', pic_nama = '$pic', pic_alamat = '$pic_alamat', pic_kontak = '$pic_kontak' WHERE customer_id = '$id_customer'";
		$mwk = $db1->prepare($query_insert);
		$mwk -> execute();
		$resli = $mwk->get_result();
		if($resli->num_rows>0){
			echo "Gagal Update Data, silahkan ulangi";
		} else{
			echo "Yeay! Insert Data Berhasil...";
		}
	}
	// var_dump($_POST);
?>