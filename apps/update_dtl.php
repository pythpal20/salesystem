<?php
	include 'route/config.php';
	$id 	= $_POST['iditem'];
	$nopo 	= $_POST['nopo'];
	$sku 	= $_POST['sku'];
	$tgl 	= $_POST['tgl'];
	$prdHarga = $_POST['prdHarga'];
	$qty 	= $_POST['qty'];
	$harga 	= $_POST['harga'];
	$amount = $_POST['amount'];
	$diskon = $_POST['nominal_discount'];
	$harga_total = $_POST['harga_total'];
	$ppn 	= $_POST['hitungan_ppn'];
	$ket 	= $_POST['ket'];

	var_dump($_POST);

	$query = "UPDATE salesorder_dtl SET tgl_po = '$tgl', harga_ref = '$prdHarga' , model = '$sku', qty = '$qty', price = '$harga', amount = '$amount', ppn = '$ppn', harga_total = '$harga_total', diskon = '$diskon', keterangan= '$ket' WHERE id = '$id' AND noso = '$nopo'";
	$mwk = $db1 -> prepare($query);
	$mwk -> execute();
	$resl = $mwk -> get_result();
?>