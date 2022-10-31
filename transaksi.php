<?php

$title = 'Transaksi';
$nm_hal = 'transaksi';

include "template/header.php";

loginpengunjung();

$id_pembeli = $_SESSION['id_pembeli'];
$daftarproduk = query("SELECT * FROM pembelian WHERE id_pembeli = '$id_pembeli'");

$querycek = mysqli_query($conn, "SELECT * FROM pembelian WHERE id_pembeli = '$id_pembeli'");
$cek = mysqli_num_rows($querycek);

if ($cek == 0) {
  echo "<script>
  alert('Transaksi kosong, silahkan belanja dahulu');
  window.location.href = 'daftarproduk.php';
  </script>";
}

?>

<section class="dashboard section">
  <div class="container">
    <!-- Row Start -->
    <div class="row">
      <div class="col-md-10 offset-md-1 col-lg-4 offset-lg-0">
        <div class="sidebar">
          <!-- User Widget -->
          <div class="widget user-dashboard-profile">
            <!-- User Image -->
            <div class="profile-thumb">
              <img src="assets/img/<?= $pembeli['foto_pembeli']; ?>" alt="" class="rounded-circle" style="width: 120px; height:120px;">
            </div>
            <!-- User Name -->
            <h5 class="text-center"><?= $pembeli['username_pembeli']; ?></h5>
            <a href="profile.php" class="btn btn-main-sm">Edit Profile</a>
          </div>
        </div>
      </div>

      <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-0">
        <!-- Recently Favorited -->
        <div class="widget dashboard-container my-adslist">
          <h3>Transaksi</h3>
            <table class="table table-responsive">
              <thead>
                <tr>
                  <th>No</th>
                  <th>ID Transaksi</th>
                  <th>Tanggal Transaksi</th>
                  <th>Pengiriman</th>
                  <th>Total Bayar</th>
                  <th>Status</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                foreach ($daftarproduk as $d) :
                ?>
                <tr>
                  <th><?= $i; ?></th>
                  <td><?= $d['id_pembelian']; ?></td>
                  <td><?= date("d F Y, H:i", strtotime($d['tgl_pembelian'])); ?></td>
                  <td><?= $d['alamat_pengiriman']; ?></td>
                  <td>Rp. <?= number_format($d['total_pembelian']); ?></td>
                  <td>
                        <?php if($d['status_pembelian'] == 1) { ?>
                        <nav class="badge badge-info">Sudah kirim pembayaran</nav>
                        <?php } elseif($d['status_pembelian'] == 2) { ?>
                          <nav class="badge badge-info">Barang dikirim</nav>
                        <?php } elseif($d['status_pembelian'] == 3) { ?>
                          <nav class="badge badge-success">Barang Sudah Sampai</nav>
                        <?php } elseif($d['status_pembelian'] == 4) { ?>
                          <nav class="badge badge-success">Berhasil</nav>
                        <?php } elseif($d['status_pembelian'] == 5) { ?>
                          <nav class="badge badge-danger">Gagal</nav>
                        <?php } elseif($d['status_pembelian'] == 6) { ?>
                          <nav class="badge badge-warning">Diproses Penjual</nav>
                        <?php } else { ?>
                          <nav class="badge badge-warning">Belum dibayar</nav>
                        <?php } ?>
                  </td>
                  <td class="action">
                      <ul class="list-inline justify-content-center">
                        <li class="list-inline-item mb-2">
                          <a data-toggle="tooltip" data-placement="top" title="Lihat nota" class="view" href="nota.php?id=<?= $d['id_pembelian']; ?>">
                            <i class="fa fa-eye"></i>
                          </a>
                        </li>
                        <br>
                        <?php if ($d['status_pembelian'] == 0) { ?>
                          <li class="list-inline-item mb-2">
                            <a class="delete" data-toggle="tooltip" data-placement="top" title="Hapus" href="hapustransaksi.php?id=<?= $d['id_pembelian']; ?>" onclick="return confirm('Apakan anda yakin menghapus transaksi <?= $d['id_pembelian']; ?>');">
                              <i class="fa fa-trash"></i>
                            </a>
                          </li>
                          <br>
                          <li class="list-inline-item mb-2">
                            <a class="edit" data-toggle="tooltip" data-placement="top" title="Pembayaran" href="pembayaran.php?id=<?= $d['id_pembelian']; ?>">
                              <i class="fa fa-money"></i>
                            </a>
                          </li>
                        <?php } ?>

                        <?php if($d['status_pembelian'] == 5) { ?>
                          <li class="list-inline-item mb-2">
                            <a class="delete" data-toggle="tooltip" data-placement="top" title="Hapus" href="hapustransaksi.php?id=<?= $d['id_pembelian']; ?>" onclick="return confirm('Apakan anda yakin menghapus transaksi <?= $d['id_pembelian']; ?>');">
                              <i class="fa fa-trash"></i>
                            </a>
                          </li>
                        <?php } ?>
                      </ul>
                  </td>
                </tr>
              <?php
              $i++;
              endforeach; ?>
              </tbody>
            </table>
          </div>
      </div>
    </div>
    <!-- Row End -->
  </div>
  <!-- Container End -->
</section>

<?php include "template/footer.php"; ?>