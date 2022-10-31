<?php

include "../../function.php";

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

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Download Laporan</title>
  <!-- Custom styles for this template -->
  <!-- <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->

</head>
<body onload="window.print()">
  <div class="container">
        <?= $judul; ?>
            <table border="1" cellpadding = "3" width="100%" cellspacing="0">
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
              <tbody id="viewdata">
              <?php 
                  
                  $i = 1;
                  foreach ($result as $data) :
    
                  ?>
                    <tr>
                        <td><?= $i; ?>. </td>
                        <td><?= $data['id_pembelian']; ?></td>
                        <td><?= $data['nama_pembeli']; ?></td>
                        <td><?= date("d F Y, H:i", strtotime($data['tgl_pembelian'])); ?></td>
                        <td>Rp. <?= number_format($data['total_pembelian']); ?></td>
                        <td>
                          <?php if($data['status_pembelian'] == 1) { ?>
                          <nav>Sudah kirim pembayaran</nav>
                          <?php } elseif($data['status_pembelian'] == 2) { ?>
                            <nav>Barang dikirim</nav>
                          <?php } elseif($data['status_pembelian'] == 3) { ?>
                            <nav>Barang Sudah Sampai</nav>
                          <?php } elseif($data['status_pembelian'] == 4) { ?>
                            <nav>Berhasil</nav>
                          <?php } elseif($data['status_pembelian'] == 5) { ?>
                            <nav>Gagal</nav>
                          <?php } elseif($data['status_pembelian'] == 6) { ?>
                            <nav>Diproses Penjual</nav>
                          <?php } else { ?>
                            <nav>Belum dibayar</nav>
                          <?php } ?>
                        </td>
                    </tr>
                  <?php
                  $total += $data['total_pembelian'];
                  $i++;
                  endforeach; ?>
              </tbody>
              <tbody>
                <tr>
                  <th colspan="4" class="text-center">Total</th>
                  <th>Rp. <?= number_format($total); ?></th>
                </tr>
              </tbody>
            </table>
  </div>  
</body>
</html>
