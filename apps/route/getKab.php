<?php
	include 'config.php';
 
	$data = $_POST['data'];
	$id = $_POST['id'];
 	var_dump($id);
	$n=strlen($id);
	$m=($n==2?5:($n==5?8:13));
	// $wil=($n==2?'Kota/Kab':($n==5?'Kecamatan':'Desa/Kelurahan'));
?>
<?php 
	if($data == "kabupaten"){
?>
<select id="kab" class="form-control" name="kab">
	<option value="">Pilih Kabupaten/Kota</option>
	<?php 
		$kabupaten = "SELECT wilayah_id,wilayah_nama FROM master_wilayah WHERE LEFT(wilayah_id,'$n')='$id' AND CHAR_LENGTH(wilayah_id)=$m ORDER BY wilayah_nama";
		$mwk=$db1->prepare($kabupaten);
		$mwk->execute();
		$resl=$mwk->get_result();
		while ($kb=$resl->fetch_assoc()){
			echo '<option value="'.$kb['wilayah_id'].'">'.$kb['wilayah_nama'].'</option>';
		}
	?>
</select>
<?php
}
?>
<!-- 
SO System 1.0 By Paulus Christofel S
PT. Multi Wahana Kencana
IT Programmer Tim
paulus.mwk@gmail.com
Agustus 2021 
-->
		