<?php
include 'route/config.php';
$cekTgl = date('ymd');

$query = "SELECT MAX(noso) AS idArr FROM salesorder_hdr";
$mwk = $db1->prepare($query);
$mwk->execute();
$res1 = $mwk->get_result();
while ($sb = $res1->fetch_assoc()) {
    $idPo  = $sb['idArr'];
    $urutan = (int) substr($idPo, 9, 9);
    $urutan++;
    $huruf = "SO";
    $idPo = $huruf . $cekTgl ."-". sprintf("%03s", $urutan);
}
$nopo = $idPo;
$customer = $_POST['customer'];
$tanggal = $_POST['tanggal'];
$alamat_kirim = $_POST['alamatKirim'];
$perusahaan = $_POST['jenisPerusahaan'];
$nopo_ref = $_POST['nopo_ref'];
$sales = $_POST['sales'];
$ongkir = $_POST['ongkir'];
$keterangan = $_POST['keterangan'];
$term = $_POST['top'];
$tgl_krm = $_POST['tglkirim'];
// $status = $_POST['statcust'];
if (isset($_POST['statcust'])){
	$sql = "UPDATE master_customer SET status = 'new' WHERE customer_id ='$customer'";
	$result_sql =mysqli_query($connect,$sql);
} else {
	$sql2 = "UPDATE master_customer SET status = 'old' WHERE customer_id ='$customer'";
	$result_sql2 = mysqli_query($connect, $sql2);
}

$query = "INSERT INTO salesorder_hdr ( noso, tgl_po,customer_id,alamat_krm, id_perusahaan, term, noso_ref, sales, ongkir, keterangan, tgl_krm)
   VALUES
   ( '$nopo', '$tanggal','$customer','$alamat_kirim','$perusahaan', '$term', '$nopo_ref','$sales','$ongkir','$keterangan', '$tgl_krm')";
$hasil = mysqli_query($connect, $query);

echo $nopo;
?>