<?php
$title = 'Checkout';

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
          <h3>Checkout</h3>
          <table class="table table-responsive">
            <thead>
              <tr>
                <!-- <th></th> -->
                <th>No</th>
                <th>Gambar</th>
                <th>Produk</th>
                <th class="text-center">Kategori</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              $totalbelanja = 0;
              $totalberat = 0;
              foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) :
                $query = mysqli_query($conn, "SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis WHERE produk.id_produk = '$id_produk'");
                $tampilproduk = mysqli_fetch_assoc($query);

              ?>
                <tr>
                  <th><?= $i; ?></th>
                  <td class="product-thumb">
                    <a href="detailproduk.php?id=<?= $tampilproduk['id_produk']; ?>"><img width="80px" height="auto" src="assets/img/produk/<?= $tampilproduk['foto_produk']; ?>" alt="image description"></a>
                  </td>
                  <td class="product-details">
                    <h3 class="title"><?= $tampilproduk['nama_produk']; ?></h3>
                    <span><strong>Harga </strong>Rp. <?= number_format($tampilproduk['harga_produk']); ?></span>
                    <form action="ubahkeranjang.php" method="POST">
                      <input type="hidden" name="id_produk" value="<?= $tampilproduk['id_produk']; ?>">
                      <span><strong>Jumlah Beli </strong> <?= $jumlah; ?> Buah</span>
                    </form>

                    <?php
                    $subberat = $jumlah * $tampilproduk['berat_produk'];
                    $subtotal = $tampilproduk['harga_produk'] * $jumlah;
                    ?>

                    <span><strong>Subberat </strong><?= number_format($subberat); ?> Gram</span>
                    <span><strong>Subharga </strong>Rp. <?= number_format($subtotal); ?></span>
                  </td>
                  <td class="product-category"><span class="categories"><?= $tampilproduk['jenis']; ?></span></td>
                </tr>
              <?php
                $i++;
                $totalbelanja += $subtotal;
                $totalberat += $subberat;
              endforeach; ?>
            </tbody>
            <tbody>
              <tr>
                <th colspan="3" class="text-center">Total Belanja</th>
                <th>Rp. <?= number_format($totalbelanja); ?></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <form method="post">

      <?php
      $q = mysqli_query($conn, "SELECT MAX(RIGHT(id_pembelian,4)) AS kd_max FROM pembelian");
      $jml = mysqli_num_rows($q);
      $kd = "";
      if ($jml > 0) {
        while ($result = mysqli_fetch_assoc($q)) {
          $tmp = ((int)$result['kd_max']) + 1;
          $kd = sprintf("%04s", $tmp);
        }
      } else {
        $kd = "0001";
      }
      $id_pembelian = date('dmy') . $kd;
      ?>
      <input type="hidden" name="id_pembelian" value="<?= $id_pembelian; ?>">

      <div class="row">
        <div class="col-md-12">
          <?php if (isset($_GET['pesan_error'])) { ?>
            <div class="alert alert-danger">
              <?= $_GET['pesan_error']; ?>
            </div>
          <?php } ?>
          <label class="form-label">Alamat Pengiriman</label>
          <textarea name="alamat_pengiriman" class="form-control mb-3" style="height: 100px;" rows="10" required><?= $pembeli['alamat_pembeli']; ?></textarea>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="nama_provinsi">Provinsi </label> <br>
                <select name="nama_provinsi" id="nama_provinsi" class="form-control select2">

                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="distrik" class="form-label">Distrik</label> <br>
                <select name="nama_distrik" id="distrik" class="form-control select2">

                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="ekspedisi" class="form-label">Ekspedisi</label> <br>
                <select name="nama_ekspedisi" id="ekspedisi" class="form-control select2">

                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="nama_paket" class="form-label">Paket</label> <br>
                <select name="nama_paket" id="nama_paket" class="form-control select2">

                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-2">
              <label class="form-label">Total berat (Gram)</label>
              <input type="text" name="total_berat" value="<?= $totalberat; ?>" class="form-control disabled" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label">Provinsi</label>
              <input type="text" name="provinsi" class="form-control" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label">Distrik</label>
              <input type="text" name="distrik" class="form-control" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label">Tipe</label>
              <input type="text" name="tipe" class="form-control" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label">Kode POS</label>
              <input type="text" name="kodepos" class="form-control" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label">Ekspedisi</label>
              <input type="text" name="ekspedisi" class="form-control" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label">Paket</label>
              <input type="text" name="paket" class="form-control" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label">Ongkir (Rp)</label>
              <input type="number" name="ongkir" class="form-control" readonly>
            </div>
            <div class="col-md-2">
              <label class="form-label">Estimasi (Hari)</label>
              <input type="text" name="estimasi" class="form-control" readonly>
            </div>

          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-success mt-4" name="checkout">Checkout</button>
    </form>
  </div>
  <!-- Row End -->
  </div>
  <!-- Container End -->
</section>

<?php

if (isset($_POST['checkout'])) {
  $id_pembeli = $_SESSION['id_pembeli'];
  $total_berat = $_POST['total_berat'];
  $provinsi = $_POST['provinsi'];
  $distrik = $_POST['distrik'];
  $tipe = $_POST['tipe'];
  $kodepos = $_POST['kodepos'];
  $ekspedisi = $_POST['ekspedisi'];
  $paket = $_POST['paket'];
  $ongkir = $_POST['ongkir'];
  $estimasi = $_POST['estimasi'];

  $alamat_pengiriman = $_POST['alamat_pengiriman'];
  $tgl_pembelian = date('Y-m-d H:i:s');
  $id_pembelian = $_POST['id_pembelian'];
  $status_pembelian = 0;  // pending
  $pesan_error = "";

  if ($provinsi == "") {
    $pesan_error .= "<b>Provinsi</b> wajib diisi <br>";
  }
  if ($distrik == "") {
    $pesan_error .= "<b>Distrik</b> wajib diisi <br>";
  }
  if ($tipe == "") {
    $pesan_error .= "<b>Tipe</b> wajib diisi <br>";
  }
  if ($ekspedisi == "") {
    $pesan_error .= "<b>Ekspedisi</b> wajib diisi <br>";
  }
  if ($paket == "") {
    $pesan_error .= "<b>Paket</b> wajib diisi <br>";
  }
  if ($ongkir == "") {
    $pesan_error .= "<b>Ongkir</b> wajib diisi <br>";
  }
  if ($estimasi == "") {
    $pesan_error .= "<b>Estimasi</b> wajib diisi <br>";
  }

  if ($pesan_error == "") {
    $totalpembelian = $totalbelanja + $ongkir;
    // simpan data ke tabel pembelian
    $pembelian = "INSERT INTO `pembelian` (`id_pembelian`, `id_pembeli`, `alamat_pengiriman`, `tgl_pembelian`, `total_pembelian`, `status_pembelian`, `totalberat`, `provinsi`, `distrik`, `tipe`, `kodepos`, `ekspedisi`, `paket`, `ongkir`, `estimasi`) VALUES ('$id_pembelian', '$id_pembeli', '$alamat_pengiriman', '$tgl_pembelian', '$totalpembelian', '$status_pembelian', '$total_berat', '$provinsi', '$distrik', '$tipe', '$kodepos', '$ekspedisi', '$paket', '$ongkir', '$estimasi')";
    $insert_pembelian = mysqli_query($conn, $pembelian);

    if ($insert_pembelian) {
      // simpan data ke pembelian_produk
      foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) :
        $query = mysqli_query($conn, "SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis WHERE produk.id_produk = '$id_produk'");
        $tampilproduk = mysqli_fetch_assoc($query);
        $subtotal = $tampilproduk['harga_produk'] * $jumlah;

        mysqli_query($conn, "INSERT INTO `pembelian_produk` (`id_pembelian_produk`, `id_pembelian`, `id_produk`, `jml_pembelian`, `total`) VALUES (NULL, '$id_pembelian', '$id_produk', '$jumlah', '$subtotal')");
      endforeach;
    }

    // mengosongkan keranjang
    unset($_SESSION['keranjang']);

    echo "
    <script>
    alert('Pembelian Sukses');
    window.location.href = 'nota.php?id=$id_pembelian';
    </script>
    ";
  } else {
    echo "
    <script>
    window.location.href = 'checkout.php?pesan_error=$pesan_error';
    </script>";
  }
} else {
  $pesan_error = "";
}

?>

<?php include "template/footer.php"; ?>

<script>
  $(document).ready(function() {
    $.ajax({
      type: 'post',
      url: 'dataprovinsi.php',
      success: function(hasil_provinsi) {
        console.log(hasil_provinsi);
        $("select[name=nama_provinsi]").html(hasil_provinsi);
        // $("select#nama_provinsi").html(hasil_provinsi);
      }
    });

    // nama provinsi diganti
    $('select[name=nama_provinsi]').on('change', function() {
      // ambil id provinsi dari select
      var id_provinsi_terpilih = $("option:selected", this).attr('id_provinsi');
      $.ajax({
        type: "post",
        url: 'datadistrik.php',
        data: 'id_provinsi=' + id_provinsi_terpilih,
        success: function(hasil_distrik) {
          $("select[name=nama_distrik]").html(hasil_distrik);

          // mengosonkan input
          $('input[name=provinsi]').val('');
          $('input[name=distrik]').val('');
          $('input[name=tipe]').val('');
          $('input[name=kodepos]').val('');
          $('input[name=ekspedisi]').val('');
          $('input[name=paket]').val('');
          $('input[name=ongkir]').val('');
          $('input[name=estimasi]').val('');
          $('select[name=nama_paket]').html('');
        }
      })
    });

    // menampilkan ekspedisi
    $.ajax({
      type: 'post',
      url: 'dataekspedisi.php',
      success: function(hasil_ekspedisi) {
        $("select[name=nama_ekspedisi]").html(hasil_ekspedisi);
      }
    });

    $('select[name=nama_ekspedisi]').on('change', function() {
      // mendapatkan data ongkir
      // mendapatkan ekspedisi yg dipilih
      // var ekspedisi_terpilih = $('select[name=nama_ekspedisi]').val();
      var ekspedisi_terpilih = $('option:selected', this).val();
      // mendapatkan id distrik yg dipilih pengguna
      // menggambil atribut pribadi id_distrik = ""
      var distrik_terpilih = $("option:selected", 'select[name=nama_distrik]').attr('id_distrik');
      // mendapatkan total berat dari inputan
      var total_berat = $("input[name=total_berat]").val();

      $.ajax({
        type: 'post',
        url: 'datapaket.php',
        data: 'ekspedisi=' + ekspedisi_terpilih + '&distrik=' + distrik_terpilih + '&berat=' + total_berat,
        success: function(hasil_paket) {
          // console.log(hasil_paket);
          console.log(ekspedisi_terpilih);
          $("select[name=nama_paket]").html(hasil_paket);
          // letakkan nama ekspedisi terpilih di input ekspedisi
          $('input[name=ekspedisi]').val(ekspedisi_terpilih);
          datapaket
          // mengosongkan input
          $('input[name=paket]').val('');
          $('input[name=ongkir]').val('');
          $('input[name=estimasi]').val('');
        }
      })
    });

    // megisi inputan
    $("select[name=nama_distrik]").on('change', function() {
      var prov = $('option:selected', this).attr('nama_provinsi');
      var dist = $('option:selected', this).attr('nama_distrik');
      var tipe = $('option:selected', this).attr('tipe_distrik');
      var kodepos = $('option:selected', this).attr('kodepos');

      $('input[name=provinsi]').val(prov);
      $('input[name=distrik]').val(dist);
      $('input[name=tipe]').val(tipe);
      $('input[name=kodepos]').val(kodepos);

      $('input[name=ekspedisi]').val('');
      $('input[name=paket]').val('');
      $('input[name=ongkir]').val('');
      $('input[name=estimasi]').val('');
      $('select[name=nama_paket]').html('');
    });

    // megisi inputan
    $("select[name=nama_paket]").on('change', function() {
      var paket = $('option:selected', this).attr('paket');
      var ongkir = $('option:selected', this).attr('ongkir');
      var etd = $('option:selected', this).attr('etd');

      $('input[name=paket]').val(paket);
      $('input[name=ongkir]').val(ongkir);
      $('input[name=estimasi]').val(etd);
    });

  })
</script>