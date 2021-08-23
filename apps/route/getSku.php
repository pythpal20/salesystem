<?php 
// $connect = mysqli_connect("localhost", "root", "", "db_customer");
include 'config.php';
$ambil_sku ="SELECT model FROM master_produk";
$hasil_sku = mysqli_query($connect, $ambil_sku);
$html="";
while ($row = mysqli_fetch_array($hasil_sku)) {
    $html .="<option value='".$row['model']."'>".$row['model']."</option>";
}
echo $html;
	// $sumber = 'http://horekadepot.com/stokgudang/API/get_data.php';
	// $response = file_get_contents($sumber);
	// $arr = json_decode($response, true);
	// $html="";
	// foreach ($arr as $key) {
	// 	# code...
	// 	$html .= "<option value='". $key['sku'] ."'>". $key['sku'] ."</option>";
	// }
	// echo $html;
?>