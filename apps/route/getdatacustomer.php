<?php
include 'config.php';
$id = $_POST['id_customer'];
// var_dump($_POST);

$query = "SELECT cs.alamat, cs.alamat_krm, sl.nama FROM customer cs
JOIN sales sl ON cs.id_sales = sl.id_sales
WHERE id_customer='$id'";
$mwk = $po->prepare($query);
$mwk->execute();
$resl=$mwk->get_result();
while ($row=$resl->fetch_assoc()) {
	$data = array(
			'alamat'	=> $row['alamat'],
			'alamat_krm'=> $row['alamat_krm'];
}
//tampil data
echo json_encode($data);
?>