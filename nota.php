<?php

$title = 'Detail Transaksi';

include "template/header.php";

loginpengunjung();

$totalpembelian = 0;
$totalberat = 0;

$id_pembelian = $_GET['id'];
$id_pembeli = $_SESSION['id_pembeli'];

$datatransaksi = query("SELECT * FROM pembelian WHERE pembelian.id_pembelian = '$id_pembelian'")[0];
$tgl_transaksi = $datatransaksi['tgl_pembelian'];
$id_pembeli_transaksi = $datatransaksi['id_pembeli'];
$status_pembelian = $datatransaksi['status_pembelian'];

if ($id_pembeli !== $id_pembeli_transaksi) {
  echo "
  <script>
  alert('Jangan Nakal Kamu Ya !');
  window.location.href = 'transaksi.php';
  </script>
  ";
}

$transaksi = query("SELECT * FROM pembelian_produk INNER JOIN pembelian ON pembelian_produk.id_pembelian = pembelian.id_pembelian INNER JOIN produk ON pembelian_produk.id_produk = produk.id_produk INNER JOIN jenis ON produk.id_jenis = jenis.id_jenis WHERE pembelian_produk.id_pembelian = '$id_pembelian'");

$resi = query("SELECT * FROM pembelian WHERE id_pembelian = '$id_pembelian'")[0];
$no_resi = $resi['no_resi'];

// cari data pembayaran
$query_pem = mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pembelian = '$id_pembelian'");
$cek = mysqli_num_rows($query_pem);
$pem = mysqli_fetch_assoc($query_pem);

?>

<section class="dashboard section">
<div class="container">
  <div class="row">
    <div class="col-md-10 offset-md-1 col-lg-4 offset-lg-0">
      <div class="sidebar">
          <div class="widget dashboard-container my-adslist">
          <h3 class="widget-header">Pengiriman</h3>
            <p>
              <b>Alamat Toko : </b><?= $toko['alamat']; ?>
            </p>
            <p>
              <b>Ongkos Pengiriman : </b>Rp. <?= number_format($resi['ongkir']); ?>
            </p>
            <p>
              <b>Ekspedisi : </b><?= $resi['ekspedisi']; ?> <?= $resi['paket']; ?> <?= $resi['estimasi']; ?>
            </p>
            <p>
              <b>Alamat Pengiriman :</b> <?= $resi['alamat_pengiriman']; ?> 
            </p>
          </div>

          <div class="widget user-dashboard-profile">
            <p class="text-left">
              <b>Tanggal : </b> <?= date("d F Y"); ?>
            </p>
          <table class="table table-responsive">
            <tr>
              <th class="text-left">ID Transaksi</th>
              <td class="text-left"><?= $id_pembelian; ?></td>
            </tr>
            <?php if ($no_resi !== "") : ?>
            <tr>
              <th class="text-left">No. Resi</th>
              <td class="text-left"><?= $no_resi; ?></td>
            </tr>
            <?php endif; ?>
            <tr>
              <th class="text-left">Tanggal Transaksi</th>
              <td class="text-left"><?= date("d F Y, H:i", strtotime($tgl_transaksi)); ?></td>
            </tr>
            <tr>
              <th class="text-left">Pembeli</th>
              <td class="text-left"><?= $pembeli['nama_pembeli']; ?></td>
            </tr>
            <tr>
              <th class="text-left">Jenis Kelamin</th>
              <td class="text-left"><?= $pembeli['jk_pembeli']; ?></td>
            </tr>
            <tr>
              <th class="text-left">No. Telp / WA</th>
              <td class="text-left"><?= $pembeli['telp_pembeli']; ?></td>
            </tr>
            <tr>
              <th class="text-left">E-mail</th>
              <td class="text-left"><?= $pembeli['email_pembeli']; ?></td>
            </tr>
            <tr>
              <th class="text-left">Status</th>
              <td class="text-left">
                        <?php if($status_pembelian == 1) { ?>
                        <nav class="badge badge-info">Sudah kirim pembayaran</nav>
                        <?php } elseif($status_pembelian == 2) { ?>
                          <nav class="badge badge-info">Barang dikirim</nav>
                        <?php } elseif($status_pembelian == 3) { ?>
                          <nav class="badge badge-success">Barang Sudah Sampai</nav>
                        <?php } elseif($status_pembelian == 4) { ?>
                          <nav class="badge badge-success">Berhasil</nav>
                        <?php } elseif($status_pembelian == 5) { ?>
                          <nav class="badge badge-danger">Gagal</nav>
                        <?php } elseif($status_pembelian == 6) { ?>
                          <nav class="badge badge-warning">Diproses Penjual</nav>
                        <?php } else { ?>
                          <nav class="badge badge-warning">Belum dibayar</nav>
                        <?php } ?>
              </td>
            </tr>
            <tr>
          </table>
          </div>

          <?php if ($cek > 0) { ?>
            <div class="widget user-dashboard-profile">
              <h3 class="widget-header">Bukti Pembayaran</h3>
                <a href="assets/img/bukti/<?= $pem['bukti']; ?>" target="_blank"><img src="assets/img/bukti/<?= $pem['bukti']; ?>" style="width: 280px;"></a>
            </div>
          <?php } ?>

      </div>
    </div>

    <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
        <div class="widget dashboard-container my-adslist">
        <h3 class="widget-header">Daftar Belanja</h3>
          <div class="alert alert-success" role="alert">
            Silahkan melakukan pembayaran <b>Rp. <?= number_format($resi['total_pembelian']); ?></b> ke Bank 
            <b></b>
          </div>
            <table class="table table-responsive">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Gambar</th>
                  <th>Produk</th>
                  <th class="text-center">Kategori</th>
                </tr>
              </thead>
              <?php
                $i = 1;
                foreach ($transaksi as $t) :
                $subberat = $t['jml_pembelian'] * $t['berat_produk'];
                ?>
                <tr>
                  <th><?= $i; ?></th>
                  <td class="product-thumb">
                    <a href="detailproduk.php?id=<?= $t['id_produk']; ?>"><img width="80px" height="auto" src="assets/img/produk/<?= $t['foto_produk']; ?>" alt="image description"></a>
                  </td>
                  <td class="product-details">
                    <h3 class="title"><?= $t['nama_produk']; ?></h3>
                    <span><strong>Harga </strong>Rp. <?= number_format($t['harga_produk']); ?></span>
                    <span><strong>Jumlah Beli </strong> <?= $t['jml_pembelian']; ?> Buah</span>
                    <span><strong>Subberat </strong><?= number_format($subberat); ?> Gram</span>
                    <span><strong>Subharga </strong>Rp. <?= number_format($t['total']); ?></span>
                  </td>
                  <td class="product-category"><span class="categories"><?= $t['jenis']; ?></span></td>
                </tr>
              <?php
              $i++;
              $totalberat += $subberat;
              $totalpembelian += $t['total'];
              endforeach; ?>
              </tbody>
              <tbody>
                <tr>
                  <th colspan="2" class="text-center">Total Belanja</th>
                  <th>Rp.</th>
                  <th><?= number_format($totalpembelian); ?></th>
                </tr>
              </tbody>
              <tbody>
                <tr>
                  <th colspan="2" class="text-center">Ongkir (<?= number_format($totalberat); ?> Gram)</th>
                  <th>Rp.</th>
                  <th><?= number_format($resi['ongkir']); ?></th>
                </tr>
              </tbody>
              <tbody>
                <tr>
                  <th colspan="2" class="text-center">Total Pembayaran</th>
                  <th>Rp.</th>
                  <th><?= number_format($resi['total_pembelian']); ?></th>
                </tr>
              </tbody>
            </table>
            <a href="cetak_nota.php?id=<?= $id_pembelian; ?>" class="btn btn-primary" target="_blank">Cetak Invoice</a>

            <?php $pesan = "Transaksi $id_pembelian apakah sudah siap !" ?>
            <a href="https://wa.me/62895392518509?text=<?= $pesan; ?>" class="btn btn-success" target="_blank"><i class="fa fa-whatsapp"></i> Hubungi Penjual</a>
            <?php if($status_pembelian == 0) : ?>
              <a href="pembayaran.php?id=<?= $id_pembelian; ?>" class="btn btn-warning"><i class="fa fa-money"></i> Pembayaran</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
</section>



<?php include "template/footer.php"; ?>