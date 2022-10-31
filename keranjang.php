<?php 

$title = 'Keranjang';
$nm_hal = 'keranjang';

include "template/header.php";

loginpengunjung();

// echo "<pre>";
// print_r($_SESSION['keranjang']);
// echo "</pre>";

if (empty($_SESSION['keranjang']) || !isset($_SESSION['keranjang'])) {
  echo "<script>
  alert('Keranjang kosong, silahkan belanja dahulu');
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
              <a href="assets/img/<?= $pembeli['foto_pembeli']; ?>" class="perbesar">
                <img src="assets/img/<?= $pembeli['foto_pembeli']; ?>" alt="" class="rounded-circle" style="width: 120px; height:120px;">
              </a>
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
          <h3 class="widget-header">Keranjang</h3>
          <p style="color: red;"><b>Segera checkout produk agar produk yang anda simpan tidak hilang.</b></p>
            <table class="table table-responsive">
              <thead>
                <tr>
                  <!-- <th></th> -->
                  <th>No</th>
                  <th>Gambar</th>
                  <th>Produk</th>
                  <th class="text-center">Kategori</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) :
                $query = mysqli_query($conn, "SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis WHERE produk.id_produk = '$id_produk'");
                $tampilproduk = mysqli_fetch_assoc($query);

                // echo "<pre>";
                // print_r($tampilproduk);
                // print_r($jumlah);
                // echo "</pre>";
                ?>
                <tr>
                  <th><?= $i; ?></th>
                  <td class="product-thumb">
                    <a href="detailproduk.php?id=<?= $tampilproduk['id_produk']; ?>"><img width="80px" height="auto" src="assets/img/produk/<?= $tampilproduk['foto_produk']; ?>" alt="image description"></a>
                  </td>
                  <td class="product-details">
                    <h3 class="title"><?= $tampilproduk['nama_produk']; ?></h3>
                    <span><strong>Harga </strong>Rp. <?= number_format($tampilproduk['harga_produk']); ?></span>
                    <!-- <span><strong>Jumlah Beli </strong> <?= $jumlah; ?> Buah</span> -->
                    <form action="ubahkeranjang.php" method="POST">
                      <input type="hidden" name="id_produk" value="<?= $tampilproduk['id_produk']; ?>">
                      <span><strong>Jumlah Beli </strong>
                        <input type="number" name="tambah" value="<?= $jumlah; ?>" style="width: 60px;">
                        <button type="submit" name="simpan" class="btn btn-main-sm">Ubah</button>
                      </span>
                    </form>
                    <span><strong>Subharga </strong>Rp. <?= number_format($tampilproduk['harga_produk'] * $jumlah); ?></span>
                  </td>
                  <td class="product-category"><span class="categories"><?= $tampilproduk['jenis']; ?></span></td>
                  <td class="action" data-title="Action">
                    <div class="">
                      <ul class="list-inline justify-content-center">
                        <li class="list-inline-item">
                          <a data-toggle="tooltip" data-placement="top" title="view" class="view" href="detailproduk.php?id=<?= $tampilproduk['id_produk']; ?>">
                            <i class="fa fa-eye"></i>
                          </a>
                        </li> 
                        <li class="list-inline-item">
                          <a class="delete" data-toggle="tooltip" data-placement="top" title="Delete" href="hapuskeranjang.php?id=<?= $tampilproduk['id_produk']; ?>&produk=<?= $tampilproduk['nama_produk']; ?>">
                            <i class="fa fa-trash"></i>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php
              $i++;
              endforeach; ?>
              </tbody>
            </table>
          </div>
          <a href="daftarproduk.php" class="btn btn-primary btn-sm">Lanjutkan Belanja</a>
          <a href="checkout.php" class="btn btn-success" onclick="return confirm('Apakah data sudah benar ?');">Checkout</a>

      </div>
    </div>
    <!-- Row End -->
  </div>
  <!-- Container End -->
</section>

<?php include "template/footer.php"; ?>