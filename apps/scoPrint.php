<?php
error_reporting(0);
include 'route/config.php';
require_once('../dompdf/autoload.inc.php');
use Dompdf\Dompdf;
$dompdf = new Dompdf(); 

$no=1;
$noso = $_GET['id'];

$queryHdr = "SELECT ph.tgl_po, ph.sales, ph.noso, ph.noso_ref, cs.customer_nama, ph.alamat_krm, cs.customer_telp, cs.pic_nama, lp.nama_pt, ph.ongkir, cs.pic_kontak, ph.term, ph.tgl_krm, cs.status
FROM salesorder_hdr ph
JOIN master_customer cs ON cs.customer_id=ph.customer_id
JOIN list_perusahaan lp ON ph.id_perusahaan = lp.id_perusahaan 
WHERE ph.noso ='$noso'";
$mwk=$db1->prepare($queryHdr);
$mwk->execute();
$reslt=$mwk->get_result();
$hdr = $reslt->fetch_assoc();

// $queryinfo = ""

$queryDtl = "SELECT * FROM salesorder_dtl pd 
JOIN master_produk gd ON pd.model=gd.model
WHERE noso ='$noso' ORDER BY no_urut";
$mwk=$db1->prepare($queryDtl);
$mwk->execute();
$reslt2=$mwk->get_result();

$querysum = "SELECT SUM(qty) as total_barang, SUM(price) as total_harga, SUM(amount) as total_amount, SUM(diskon) AS total_disc, SUM(ppn) AS total_pajak, SUM(harga_total) AS ttl FROM salesorder_dtl WHERE noso='$noso'";
$mwk=$db1->prepare($querysum);
$mwk->execute();
$res1=$mwk->get_result();
$summ = $res1->fetch_assoc();

$html .='
<style>
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;

}
.center {
  margin-left: auto;
  margin-right: auto;
  margin-top: 1px;
}
.table {
	margin-top: 1px;
}
</style>';
$html .='<table border="0" width="100%" style="overflow-x:auto; font-size: 0.7em;" class="center">
<tr>
	<th scop="row" colspan="6" style="margin-left: auto; margin-right: auto;">SALES CONFIRMATION ORDER</th>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
	<th scop="row" colspan="3">No. pick tiket Sample : </th>
	<td></td>
	<td>SH : </td>
</tr>
<tr>
	<th scop="row">Date</th>
	<td>:</td>
	<td>'.$hdr["tgl_po"].'</td>
	<td> </td>
	<th scop="row">Member</th>
	<td>|</td>
	<th scope="row">'.$hdr["status"].'</th>
</tr>
<tr>
	<th scope="row">Nama Sales/Marketing</th>
	<td>:</td>
	<td>'.$hdr["sales"].'</td>
	<td></td>
	<th scope="row">No. PO</th>
	<td>:</td>
	<td>'.$hdr["noso"].'/'.$hdr['noso_ref'].'</td>
</tr>
<tr>
	<th scope="row">Customer</th>
	<td>:</td>
	<td>'.$hdr["customer_nama"].'</td>
	<td></td>
	<th scope="row">Pembayaran</th>
	<td>:</td>
	<td>'.$hdr["term"].'</td>
</tr>
<tr>
	<th scope="row" rowspan="2">Customer Address</th>
	<td rowspan="2">:</td>
	<td rowspan="2">'.$hdr["alamat_krm"].'</td>
	<td></td>
	<th>UP</th>
	<td>:</td>
	<td>'.$hdr["pic_nama"].'</td>
</tr>
<tr>
	<td></td>
	<th scope="row">No. Hp/Telp</th>
	<td>:</td>
	<td>'.$hdr["pic_kontak"].'/'.$hdr["customer_telp"].'</td>
</tr>
<tr>
	<th>Delivery Date</th>
	<td>:</td>
	<td>'.$hdr["tgl_krm"].'</td>
	<th></th>
	<th>PT. </td>
	<td>:</td>
	<td>'.$hdr["nama_pt"].'</td>
</tr>
<tr>
<th> Pengiriman Via</th>
<td>:</td>
<td></td>
</tr>
</table>';
$html .="<hr>";
$html .='<table border="1" width="100%" style="font-size: 0.7em; border-collapse: collapse;">
<thead>
	<tr>
		<th>No</th>
		<th>Spesification</th>
		<th>Qty</th>
		<th>Price</th>
		<th>Amount</th>
		<th>Disc</th>
		<th>PPN</th>
		<th>Total</th>
		<th>Keterangan</th>
	</tr>
</thead>
<tbody>';
while($dtl=$reslt2->fetch_assoc()) {
	$html .= "<tr>
	<td>".$no++."</td>
	<td>".$dtl['model']."-".$dtl['deskripsi']."</td>
	<td>".$dtl['qty']."</td>
	<td>Rp. ".number_format($dtl['price'],0,".",".")."</td>
	<td>Rp. ".number_format($dtl['amount'],0,".",".")."</td>
	<td>Rp. ".number_format($dtl['diskon'],0,".",".")."</td>
	<td>Rp. ".number_format($dtl['ppn'],0,".",".")."</td>
	<td>Rp. ".number_format($dtl['harga_total'],0,".",".")."</td>
	<td>".$dtl['keterangan']."</td>
	</tr>";
}
$html .= "<tr>
<th colspan='2'>Total</th>
<th>".$summ['total_barang']."</th>
<th>Rp. ".number_format($summ['total_harga'],0,".",".")."</th>
<th>Rp. ". number_format($summ['total_amount'],0,".",".")."</th>
<th>Rp. ". number_format($summ['total_disc'],0,".",".")."</th>
<th>Rp. ". number_format($summ['total_pajak'],0,".",".")."</th>
<th>Rp. ". number_format($summ['ttl'],0,".",".")."</th>
<th>&nbsp;</th>
</tr>
<tr>
	<th colspan='7' style='text-align:right;'>Ongkos Kirim</th>
	<th colspan='2'>Rp. ". number_format($hdr['ongkir'],0,".",".") ."</th>
</tr>
<tr>
	<th colspan='7' style='text-align:right;'>Total Payment</th>
	<th colspan='2'>Rp. ". number_format($hdr['ongkir']+$summ['ttl'],0,".",".") ."</th>
</tr>";
$html  .="</table><br>";
$html .='<table border="0" width="100%" style="margin-left: auto; margin-right: auto; font-size: 0.7em;">
<tr style="text-align:center">
	<th width="33%">Issued By</th>
	<th width="33%">Received By</th>
	<th width="33%">Acknowledge By</th>
</tr>
<tr style="text-align: center">
	<td style="height: 75px;"><img src="../img/'.$hdr['sales'].'.png" width="75px"></td>
	<td style="height: 75px;"></td>
	<td style="height: 75px;"></td>
</tr>
<tr style="text-align: center">
	<td>('.$hdr["sales"].')</td>
	<td></td>
	<td></td>
</tr>';
$html .="</html>";
	// ECHO $html;
$dompdf->load_html($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A5', 'landscape');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('Sales Confirmation Order '.$noso.'.pdf'); 

?>