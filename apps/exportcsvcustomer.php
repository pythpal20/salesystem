<?php
	include 'route/config.php';
	$kategori = $_POST['kategori'];
	$kota = $_POST['kota'];

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Customer '. $kategori .' '. $kota .'.csv');

	// BOM header UTF-8
	// echo "\xEF\xBB\xBF";

	$output = fopen('php://output', 'w');
	fputcsv($output, array('Nama Konsumen', 'ID Register', 'Kategori', 'Alamat', 'Kota', 'No. Telp', 'PIC', 'No. Hp', 'Status', 'Input By'));

	$fkategori = '%' . $kategori . '%';
	$fkota = '%' . $kota . '%';
	$query = "SELECT ms.customer_nama, ms.customer_idregister, ms.customer_kategori, ms.customer_alamat, mw.wilayah_nama, ms.customer_telp, ms.pic_nama, ms.pic_kontak, ms.status, ms.input_by
	FROM master_customer ms
	JOIN master_wilayah mw ON ms.customer_kota = mw.wilayah_id
	WHERE ms.customer_kategori LIKE ? AND ms.customer_kota LIKE ? ORDER BY customer_nama ASC";
	$mwk = $db1->prepare($query);
	$mwk->bind_param('ss', $fkategori, $fkota);
	$mwk->execute();
	$reslt = $mwk->get_result();

	while ($row = $reslt->fetch_assoc()) fputcsv($output, $row);
?>