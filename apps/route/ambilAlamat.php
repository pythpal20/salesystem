<?php
include 'config.php';
$id = $_POST['idcust'];
// var_dump($_POST);

$query = "SELECT customer_alamat FROM master_customer
WHERE customer_id = '$id'";
$mwk = $db1->prepare($query);
$mwk->execute();
$resl=$mwk->get_result();
while ($row=$resl->fetch_assoc()) {
	$data = array(
			'alamat'	=> $row['customer_alamat']);
}
//tampil data
echo json_encode($data);
?>