<?php

include "../../function.php";

require_once '../../vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();

$tgl_mulai = $_GET['tglm'];
$tgl_selesai = $_GET['tgls'];
$status = $_GET['status'];

if ($tgl_mulai !== "" && $tgl_selesai !=="" && $status !== "") {
  $result = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli WHERE tgl_pembelian BETWEEN '$tgl_mulai' AND '$tgl_selesai' AND status_pembelian = '$status'");
  $judul = '<h2>Laporan Transaksi Pembelian Tanggal "'.date("d F Y", strtotime($tgl_mulai)).'" hingga "'.date("d F Y", strtotime($tgl_selesai)).'"</h2>';
} else {
  $result = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli");
  $judul = '<h2>Laporan Transaksi Pembelian</h2>';
}

$total = 0;


$html = $judul.'
<table width="100%" border="1" cellpadding ="5" cellspacing="0">
  <thead>
      <tr>
        <th>No.</th>
        <th>ID Transaksi</th>
        <th>Nama Pembeli</th>
        <th>Tgl Pembelian</th>
        <th>Total Pembelian</th>
        <th>Status</th>
      </tr>
    </thead>
  <tbody id="viewdata"> ';
      
      $i = 1;
      foreach ($result as $data) :

       $html .= " <tr>
            <td>".$i.". </td> ';

            <td>".$data['id_pembelian']."</td>
            <td>".$data['nama_pembeli']."</td>
            <td>".date("d F Y, H:i", strtotime($data['tgl_pembelian']))."</td>
            <td>Rp. ".number_format($data['total_pembelian'])."</td>
            <td>
              ";
              
              if($data['status_pembelian'] == 1) {
              
           $html .= '   <nav class="badge badge-info">Sudah kirim pembayaran</nav>';

              } elseif($data['status_pembelian'] == 2) {

             $html .= '   <nav class="badge badge-info">Barang dikirim</nav>';
              
            } elseif($data['status_pembelian'] == 3) {

             $html .= '   <nav class="badge badge-success">Barang Sudah Sampai</nav>';
            
            } elseif($data['status_pembelian'] == 4) {

             $html .= '   <nav class="badge badge-success">Berhasil</nav>';
            
            } elseif($data['status_pembelian'] == 5) {

             $html .= '   <nav class="badge badge-danger">Gagal</nav>';
              } elseif($data['status_pembelian'] == 6) {
             $html .= '   <nav class="badge badge-warning">Diproses Penjual</nav>';
              } else {
             $html .= '   <nav class="badge badge-warning">Belum dibayar</nav>';
              }
            
            $html .=  "</td></tr>";
      $total += $data['total_pembelian'];
      $i++;
      endforeach;

  $html .= '</tbody>
  <tbody>
    <tr>
      <th colspan="4" align="center">Total</th>
      <th>Rp. '.number_format($total).'</th>
    </tr>
  </tbody>
</table>
';



$mpdf->WriteHTML($html);
$mpdf->Output('laporan.pdf', \Mpdf\Output\Destination::INLINE);