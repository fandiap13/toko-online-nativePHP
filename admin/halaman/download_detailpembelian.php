<?php

include "../../function.php";

$id_pembelian = $_GET['id'];

// data toko
$toko = query("SELECT * FROM toko")[0];

$datatransaksi = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli WHERE pembelian.id_pembelian = '$id_pembelian'")[0];
$tgl_transaksi = $datatransaksi['tgl_pembelian'];
$id_pembeli_transaksi = $datatransaksi['id_pembeli'];
$status_pembelian = $datatransaksi['status_pembelian'];

$transaksi = query("SELECT * FROM pembelian_produk INNER JOIN pembelian ON pembelian_produk.id_pembelian = pembelian.id_pembelian INNER JOIN produk ON pembelian_produk.id_produk = produk.id_produk INNER JOIN jenis ON produk.id_jenis = jenis.id_jenis WHERE pembelian_produk.id_pembelian = '$id_pembelian'");

$totalpembelian = 0;

// pembelian
$resi = query("SELECT * FROM pembelian WHERE id_pembelian = '$id_pembelian'")[0];
$no_resi = $resi['no_resi'];

// cari data pembayaran
$query_pem = mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pembelian = '$id_pembelian'");
$cek = mysqli_num_rows($query_pem);
$pem = mysqli_fetch_assoc($query_pem);

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Detail Pembelian <?= $id_pembelian; ?></title>
  <!-- Custom styles for this template -->
  <link href="../../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>
<body onload="window.print()">
  <img src="../../assets/img/logo.png" width="200px" style="margin-bottom: 10px;">
  <h3>Detail Pembelian</h3>
  <table width='100%'>
    <tr>
      <td>
          <b>Alamat Toko </b> : <?= $toko['alamat']; ?> <br>
          <b>No. Hp / WA</b> : <?= $toko['telp']; ?> <br>
          <b>Email</b> : <?= $toko['email']; ?>
      </td>
      <td align="right">
        <p style="text-align: right;"> <b>Tanggal : </b><?= date("d F Y, H:i", strtotime(date('Y-m-d H:i:s'))); ?></p>
      </td>
    </tr>
  </table>

      <hr style="border:0; border-top: 5px double #8c8c8c;">

          <h5>Pembelian</h5>
              <li><b>ID Transaksi : <?= $id_pembelian; ?></b></li>
              <li><b>Tanggal Transaksi : </b> <?= date("d F Y, H:i", strtotime($resi['tgl_pembelian'])); ?></li>
              <li><b>Total Pembayaran : </b>Rp. <?= number_format($resi['total_pembelian']); ?></li>
              <li><b>Status : </b>
                        <?php if($resi['status_pembelian'] == 1) { ?>
                        Sudah kirim pembayaran
                        <?php } elseif($resi['status_pembelian'] == 2) { ?>
                          Barang dikirim
                        <?php } elseif($resi['status_pembelian'] == 3) { ?>
                          Barang Sudah Sampai
                        <?php } elseif($resi['status_pembelian'] == 4) { ?>
                          Berhasil
                        <?php } elseif($resi['status_pembelian'] == 5) { ?>
                          Gagal
                        <?php } elseif($resi['status_pembelian'] == 6) { ?>
                          Diproses Penjual
                        <?php } else { ?>
                          Belum dibayar
                        <?php } ?>
              </li>
            <h5>Pembeli</h5>
              <li><b>Username : </b><?= $datatransaksi['username_pembeli']; ?></li>
              <li><b>Pembeli :	</b><?= $datatransaksi['nama_pembeli']; ?></li>
              <li><b>Jenis Kelamin :	</b><?= $datatransaksi['jk_pembeli']; ?></li>
              <li><b>No. Telp / WA :	</b><?= $datatransaksi['telp_pembeli']; ?></li>
              <li><b>E-mail :	</b><?= $datatransaksi['email_pembeli']; ?></li>
          <h5>Pengiriman</h5>
              <li><b>Ongkos Pengiriman : </b> <?= number_format($datatransaksi['ongkir']); ?></li>
              <li>
                <b>Ekspedisi : </b><?= $datatransaksi['ekspedisi']; ?> <?= $datatransaksi['paket']; ?> <?= $datatransaksi['estimasi']; ?>
              </li>
              <li>
                <b>Alamat Pengiriman :</b> <?= $datatransaksi['alamat_pengiriman']; ?>
              </li>

              <br>
              
            <table border="1" width="100%" cellspacing="0" cellspacing="3">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Produk</th>
                      <th>Jumlah</th>
                      <th>Subtotal</th>
                      <th class="text-center">Kategori</th>
                    </tr>
                  </thead>
                  <?php
                    $i = 1;
                    foreach ($transaksi as $t) :
                    $subberat = $t['jml_pembelian'] * $t['berat_produk'];
                    ?>
                    <tr>
                      <th><?= $i; ?>. </th>
                      <td class="product-details">
                        <p><b><?= $t['nama_produk']; ?></b></p>
                        <b>Subberat </b><?= number_format($subberat); ?> Gram<br>
                      </td>
                      <td><?= $t['jml_pembelian']; ?> Buah</td>
                      <td>Rp. <?= number_format($t['total']); ?></td>
                      <td class="text-center"><span class="categories"><?= $t['jenis']; ?></span></td>
                    </tr>
                  <?php
                  $i++;
                  $totalpembelian += $t['total'];
                  endforeach; ?>
                  </tbody>
            </table>
</body>
</html>