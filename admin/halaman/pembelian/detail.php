<?php 

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

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Detail Pembelian</h4>
    </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
          <h5 class="m-0 font-weight-bold">Pembelian</h5>
              <li><b>ID Transaksi : <?= $id_pembelian; ?></b></li>
              <li><b>Tanggal Transaksi : </b><br> <?= date("d F Y, H:i", strtotime($resi['tgl_pembelian'])); ?></li>
              <li><b>Total Pembayaran : </b>Rp. <?= number_format($resi['total_pembelian']); ?></li>
              <li><b>Status : </b>
                        <?php if($resi['status_pembelian'] == 1) { ?>
                        <nav class="badge badge-info">Sudah kirim pembayaran</nav>
                        <?php } elseif($resi['status_pembelian'] == 2) { ?>
                          <nav class="badge badge-info">Barang dikirim</nav>
                        <?php } elseif($resi['status_pembelian'] == 3) { ?>
                          <nav class="badge badge-success">Barang Sudah Sampai</nav>
                        <?php } elseif($resi['status_pembelian'] == 4) { ?>
                          <nav class="badge badge-success">Berhasil</nav>
                        <?php } elseif($resi['status_pembelian'] == 5) { ?>
                          <nav class="badge badge-danger">Gagal</nav>
                        <?php } elseif($resi['status_pembelian'] == 6) { ?>
                          <nav class="badge badge-warning">Diproses Penjual</nav>
                        <?php } else { ?>
                          <nav class="badge badge-warning">Belum dibayar</nav>
                        <?php } ?>
              </li>
          </div>
          <div class="col-md-4">
            <h5 class="m-0 font-weight-bold">Pembeli</h5>
              <li><b>Username : </b><?= $datatransaksi['username_pembeli']; ?></li>
              <li><b>Pembeli :	</b><?= $datatransaksi['nama_pembeli']; ?></li>
              <li><b>Jenis Kelamin :	</b><?= $datatransaksi['jk_pembeli']; ?></li>
              <li><b>No. Telp / WA :	</b><?= $datatransaksi['telp_pembeli']; ?></li>
              <li><b>E-mail :	</b><?= $datatransaksi['email_pembeli']; ?></li>
          </div>
          <div class="col-md-4">
          <h5 class="m-0 font-weight-bold">Pengiriman</h5>
              <li><b>Alamat : <?= $toko['alamat']; ?></b></li>
              <li><b>Ongkos Pengiriman : </b> <?= number_format($datatransaksi['ongkir']); ?></li>
              <li>
                <b>Ekspedisi : </b><?= $datatransaksi['ekspedisi']; ?> <?= $datatransaksi['paket']; ?> <?= $datatransaksi['estimasi']; ?>
              </li>
              <li>
                <b>Alamat Pengiriman :</b> <?= $datatransaksi['alamat_pengiriman']; ?>
              </li>
          </div>
        </div>
        <a href="halaman/download_detailpembelian.php?id=<?= $id_pembelian; ?>" target="_blank" class="btn btn-success mt-3"><i class="fas fa-download fa-sm"></i> Download PDF</a>
        <div class="row mt-3">
          <div class="col-md-12">
          <div class="table-responsive">
            <table class="table" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Gambar</th>
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
                      <th><?= $i; ?></th>
                      <td class="product-thumb">
                        <img width="120px" height="auto" src="../assets/img/produk/<?= $t['foto_produk']; ?>" alt="image description">
                      </td>
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
          </div>
          </div>
        </div>
      </div>
  </div>
</div>


