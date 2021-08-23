<?php 
include 'route/config.php';
// include 'config/connection.php';
// insert detail po
$nopo = $_POST['nopo'];
$sku = $_POST['sku'];
$tgl = $_POST['tgl'];
$prdHarga = $_POST['prdHarga'];
$qty = $_POST['qty'];
$harga = $_POST['harga'];
$amount = $_POST['amount'];
$diskon = $_POST['nominal_discount'];
$harga_total = $_POST['harga_total'];
$ppn = $_POST['hitungan_ppn'];
$ket = $_POST['ket'];
$no_urut = $_POST['no_urut'];

// query cek
// $cek_data = "SELECT * FROM purchaseorder_dtl WHERE nopo = '$nopo'";
// $mwk = $po->prepare($cek_data);
// $mwk -> execute();
// $resl = $mwk->get_result();
// if ($resl->num_rows > 0){
// 	while($row=$resl->fetch_assoc()){
// 		$gt = $row['nopo'];
// 		$no_urut = (int) substr($gt, 4, 4);
// 		$nopo_baru = 'PO-'.$no_urut+1;
// 	}
// }
// var_dump($nopo_baru);

$query = "INSERT INTO salesorder_dtl ( noso, tgl_po,harga_ref,model,qty,price,amount,ppn,harga_total,diskon, keterangan, no_urut)
   VALUES
   ( '$nopo', '$tgl','$prdHarga','$sku','$qty','$harga','$amount','$ppn','$harga_total','$diskon', '$ket', '$no_urut')";
mysqli_query($connect, $query);

?>