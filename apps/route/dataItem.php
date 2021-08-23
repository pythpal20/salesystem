<?php 
	include 'config.php';
	/*================================
	code dibawah merupakan query untuk menampilkan data */
	/*================================*/
	$no = 1;
	// $sumber = 'http://horekadepot.com/stokgudang/API/get_data.php';
	// $response = file_get_contents($sumber);
	// $arr = json_decode($response, true);
	$query="SELECT * FROM master_produk ORDER BY barcode";
	$mwk = $db1->prepare($query);
	$mwk->execute();
	$resl = $mwk->get_result();
?>
<table class="table table-striped" id="table_id">
	<thead>
		<tr>
			<th>No</th>
			<th>Barcode</th>
			<th data-priority="1">SKU</th>
			<th>Kategori</th>
			<th>Deskripsi</th>
			<th data-priority="2">Harga jual</th>
		</tr>  
	</thead>
	<tbody>
		<?php
		while($key=$resl->fetch_assoc()){
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $key['barcode']; ?></td>
			<td data-priority="1"><?php echo $key['model']; ?></td>
			<td><?php echo $key['kategori']; ?></td>
			<td><?php echo $key['deskripsi']; ?></td>
			<td data-priority="2">Rp. <?php echo number_format($key['harga'], 0, ".", "."); ?></td>
		</tr>	
		<?php } ?>
	</tbody>
</table>