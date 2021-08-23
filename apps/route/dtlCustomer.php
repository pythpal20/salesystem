<?php
	error_reporting(0);
	include 'config.php';
	//select.php  
	if (isset($_POST["id"])) {
		$output = '';
		$query = "SELECT * FROM master_customer WHERE customer_id = '" . $_POST["id"] . "'";
		$result = mysqli_query($connect, $query);
		$row = mysqli_fetch_array($result);

		$kota = "SELECT wilayah_nama FROM master_wilayah WHERE wilayah_id = '" . $row["customer_kota"] . "'";
		$hs_kota = mysqli_query($connect, $kota);
		$kt = mysqli_fetch_array($hs_kota);

		$prov = "SELECT wilayah_nama FROM master_wilayah WHERE wilayah_id = '" . $row["customer_provinsi"] . "'";
		$hs_prov = mysqli_query($connect, $prov);
		$pv = mysqli_fetch_array($hs_prov);

		$output .= '
		<div class="table-responsive"> 
			<table class="table table-bordered">
				<tr>
					<th>Customer</th>
					<td>:</td>
					<td>'. $row['customer_nama'] . '</td>
				</tr>
				<tr>
					<th>ID Register</th>
					<td>:</td>
					<td>'. $row['customer_idregister'] . '</td>
				</tr>
				<tr>
					<th>Kategori</th>
					<td>:</td>
					<td>'. $row['customer_kategori'] . '</td>
				</tr>
				<tr>
					<th>Alamat</th>
					<td>:</td>
					<td>'. $row['customer_alamat'] . '</td>
				</tr>
				<tr>
					<th>Kota</th>
					<td>:</td>
					<td>'. $kt['wilayah_nama'] . '</td>
				</tr>
				<tr>
					<th>Provinsi</th>
					<td>:</td>
					<td>'. $pv['wilayah_nama'] . '</td>
				</tr>
				<tr>
					<th>PIC</th>
					<td>:</td>
					<td>'. $row['pic_nama'] . '</td>
				</tr>
				<tr>
					<th>Kontak</th>
					<td>:</td>
					<td>'. $row['customer_telp'] . '/'. $row["pic_kontak"] .'</td>
				</tr>
				<tr>
					<th>Tanggal Input</th>
					<td>:</td>
					<td>'. $row['tgl_input'] .'</td>
				</tr>
				<tr>
					<th>Status</th>
					<td>:</td>
					<td>'. $row['status'] .'</td>
				</tr>';
		$output .= '</table></div>';
		echo $output;
	}
?>