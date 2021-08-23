<?php
	error_reporting(0);
	include 'config.php';
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
	$cek = "SELECT * FROM master_customer WHERE customer_nama = '$nm_customer' AND customer_kategori ='$cs_kategori'";
	$mwk = $db1->prepare($cek);
	$mwk -> execute();
	$reslc = $mwk->get_result();
	if ($reslc->num_rows > 0){
		echo "Data ini sudah ada, Tambah Customer Lain";
	} else{
		$query_insert = "INSERT INTO master_customer (customer_id, customer_idregister, customer_kategori, customer_nama, customer_provinsi, customer_kota, customer_alamat, customer_telp, pic_nama, pic_alamat, pic_kontak, input_by, tgl_input) VALUES ('','$idRegister','$cs_kategori','$nm_customer', '$id_prov','$id_kota', '$cs_alamat','$cs_telp', '$pic', '$pic_alamat', '$pic_kontak', '$user', '$tglNow')";
		$mwk = $db1->prepare($query_insert);
		$mwk -> execute();
		$resli = $mwk->get_result();
		if($resli->num_rows>0){
			echo "Gagal Input Data";
		} else{
			echo "Yeay! Insert Data Berhasil...";
		}
	}
	// var_dump($_POST);
?>