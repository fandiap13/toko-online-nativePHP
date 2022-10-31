<?php 

include '../../../function.php';

$id = $_GET['id'];
$row = query("SELECT * FROM produk INNER JOIN jenis ON produk.id_jenis = jenis.id_jenis WHERE produk.id_produk = '$id'")[0];

$fotoproduk = query("SELECT * FROM foto_produk WHERE id_produk = '$id'");

$nama_produk = $row['nama_produk'];
$tgl_post = $row['tgl_post'];
$jenis_produk = $row['jenis'];
$berat_produk = $row['berat_produk'];
$harga_produk = $row['harga_produk'];
$status = $row['status_produk'];
$deskripsi_produk = $row['deskripsi_produk'];
$foto_produk = $row['foto_produk'];


if (isset($_POST['simpan'])) {
  $namaFile = $_FILES["foto"]["name"];
  $ukuran = $_FILES["foto"]["size"];
  $error = $_FILES["foto"]["error"];
  $tmp = $_FILES["foto"]["tmp_name"];
  $pesan_error_foto = "";

  $gambarvalid = ["jpg","jpeg","png"];
  $ekstensigambar = explode('.', $namaFile);
  $ekstensigambar = strtolower(end($ekstensigambar));
  if (!in_array($ekstensigambar, $gambarvalid)) {
    $pesan_error_foto = "Yang anda upload bukan gambar";
  }
  if ($ukuran > 2000000) {
    $pesan_error_foto = "Ukuran gambar terlalu besar";
  }
  $namafoto = date('is');
  $namafoto .= '_';
  $namafoto .= $namaFile;

  if ($pesan_error_foto == "") {
    move_uploaded_file($tmp, '../assets/img/produk/' .$namafoto);

    $query = mysqli_query($conn, "INSERT INTO `foto_produk` (`id_foto_produk`, `id_produk`, `nama_foto_produk`) VALUES (NULL, '$id', '$namafoto')");

    if ($query) {
      echo "
      <script>
        setTimeout(function() {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            timer: 3200,
            text: 'Foto berhasil ditambahkan',
            confirmButtonText: 'Ok',
          });
        },10);
        window.setTimeout(function() {
          window.location.href = '?halaman=produk&aksi=detail&id=$id';
        },3000);
      </script>
    ";
    }
  }
} else {
  $pesan_error_foto = "";
}

?>

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Detail Produk</h4>
    </div>
    <div class="card-body">
      <table class="table">
        <tr>
          <th>Nama Produk</th>
          <td><?= $nama_produk; ?></td>
        </tr>
        <tr>
          <th>Kategori</th>
          <td><?= $jenis_produk; ?></td>
        </tr>
        <tr>
          <th>Tanggal</th>
          <td><?= $tgl_post; ?></td>
        </tr>
        <tr>
          <th>Harga</th>
          <td>Rp. <?= number_format($harga_produk); ?></td>
        </tr>
        <tr>
          <th>Berat</th>
          <td><?= number_format($berat_produk); ?> Gram</td>
        </tr>
        <tr>
          <th>Deskripsi</th>
          <td><?= $deskripsi_produk; ?></td>
        </tr>
        <tr>
          <th>Status</th>
          <td><?= $status; ?></td>
        </tr>
      </table>
      <div class="row">
        <?php foreach($fotoproduk as $f) : ?>
          <div class="col-md-3 text-center">
            <img src="../assets/img/produk/<?= $f['nama_foto_produk']; ?>" style="width: 240px;" class="img-responsive mb-2">
            <a href="?halaman=produk&aksi=hapusfotoproduk&idf=<?= $f['id_foto_produk']; ?>&idp=<?= $f['id_produk']; ?>" class="btn btn-danger mb-2" onclick="return confirm('Apakah anda ingin menghapus foto !');"><i class="fa fa-trash"></i> Hapus</a>
          </div>
        <?php endforeach; ?>
      </div>
      <hr>

      <h4 class="m-0 font-weight-bold">Tambah Foto</h4>
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="foto" class="form-label">File Foto</label><br>
          <img src="../assets/img/default.svg" class="img-thumbnail img-preview mb-3" id="preview" style="height: 150px;">
          <input type="file" name="foto" class="form-control <?= ($pesan_error_foto !== "") ? 'is-invalid' : ''; ?>" id="foto" onchange="previewFoto();">
          <p style="color:red;">Max Ukuran Foto 2mb ("jpg","jpeg","png")</p>
          <div class="invalid-feedback">
            <?= $pesan_error_foto; ?>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
      </form>
    </div>
  </div>
</div>
 