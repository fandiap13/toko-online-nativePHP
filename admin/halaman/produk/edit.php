<?php

$id = $_GET['id'];
$row = query("SELECT * FROM produk INNER JOIN jenis ON produk.id_jenis = jenis.id_jenis WHERE produk.id_produk = '$id'")[0];

if (isset($_POST['ubah'])) {
    $nama_produk =  htmlentities(strip_tags(trim($_POST['nama_produk'])));
    $id_jenis =  htmlentities(strip_tags(trim($_POST['id_jenis'])));
    $berat_produk =  htmlentities(strip_tags(trim($_POST['berat_produk'])));
    $harga_produk =  htmlentities(strip_tags(trim($_POST['harga_produk'])));
    $status_produk =  htmlentities(strip_tags(trim($_POST['status_produk'])));
    $deskripsi_produk =  $_POST['deskripsi_produk'];
    $foto_lama = $_POST['foto_lama'];
    $namaFile = $_FILES["foto"]["name"];
    $ukuran = $_FILES["foto"]["size"];
    $error = $_FILES["foto"]["error"];
    $tmp = $_FILES["foto"]["tmp_name"];
    $pesan_error_foto = "";

    if ($error !== 4) {
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

    } else {
      $namafoto = $foto_lama;
    }

    if ($pesan_error_foto == "") {
      if ($error !== 4) {
        unlink('../assets/img/produk/'.$foto_lama);
        move_uploaded_file($tmp, '../assets/img/produk/' .$namafoto);
      }

      $query = mysqli_query($conn, "UPDATE `produk` SET `nama_produk` = '$nama_produk', `id_jenis` = '$id_jenis', `berat_produk` = '$berat_produk', `harga_produk` = '$harga_produk', `deskripsi_produk` = '$deskripsi_produk', `status_produk` = '$status_produk', `foto_produk` = '$namafoto' WHERE `produk`.`id_produk` = '$id'");

      if ($query) {
        echo "
        <script>
          setTimeout(function() {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              timer: 2200,
              text: 'Produk $nama_produk berhasil diubah',
              confirmButtonText: 'Ok',
            });
          },10);
          window.setTimeout(function() {
            window.location.href = '?halaman=produk';
          },2000);
        </script>
        ";
      }
    }


} else {
  $nama_produk =  "";
  $id_jenis =  "";
  $berat_produk =  "";
  $harga_produk =  "";
  $status_produk =  "";
  $deskripsi_produk =  "";
  $pesan_error_foto = "";
}

?>

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Edit Produk</h4>
    </div>
    <div class="card-body">
    <form method="post" enctype="multipart/form-data" id="form-tambah">
      <input type="hidden" name="foto_lama" value="<?= $row['foto_produk']; ?>">
            <div class="mb-3">
              <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Masukkan Nama Produk..." value="<?= ($nama_produk !== "") ? $nama_produk : $row['nama_produk']; ?>" required autofocus>
            </div>

            <div class="mb-3">
              <label for="id_jenis" class="form-label">Kategori Produk</label>
                <select name="id_jenis" class="form-control" id="id_jenis">
                  <?php 
                  $produk = query("SELECT * FROM jenis"); 
                  foreach ($produk as $p) :
                  ?>
                    <option value="<?= $p['id_jenis']; ?>" <?= ($row['id_jenis'] == $p['id_jenis']) ? 'selected' : ''; ?>><?= $p['jenis']; ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
              <label for="berat_produk" class="form-label">Berat Produk (Gr)</label>
              <input type="number" class="form-control" id="berat_produk" name="berat_produk" placeholder="Masukkan Berat Produk..." value="<?= ($berat_produk !== "") ? $berat_produk : $row['berat_produk']; ?>" required>
            </div>

            <div class="mb-3">
              <label for="harga_produk" class="form-label">Harga Produk (Rp)</label>
              <input type="number" class="form-control" id="harga_produk" name="harga_produk" placeholder="Masukkan Harga Produk..." value="<?= ($harga_produk !== "") ? $harga_produk : $row['harga_produk']; ?>" required>
            </div>

            <div class="mb-3">
              <label for="status_produk" class="form-label">Status Produk</label>
              <select name="status_produk" id="status_produk" class="form-control">
                <option value="Tersedia" <?= ($row['status_produk'] == "Tersedia") ? 'selected' : ''; ?>>Tersedia</option>
                <option value="Tidak tersedia" <?= ($row['status_produk'] == "Tidak tersedia") ? 'selected' : ''; ?>>Tidak tersedia</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="" class="form-label">Deskripsi Produk</label>
                <textarea name="deskripsi_produk" id="textarea" rows="5" class="form-control hapustext textarea1" required><?= ($deskripsi_produk !== "") ? $deskripsi_produk : $row['deskripsi_produk']; ?></textarea>
            </div>

          <div class="mb-3">
            <label for="foto" class="form-label">Foto Utama Produk</label>
            <br>
            <img src="../assets/img/produk/<?= $row['foto_produk']; ?>" class="img-thumbnail img-preview mb-3" id="preview" style="height: 150px;">
            <input class="form-control <?= ($pesan_error_foto !== "") ? 'is-invalid' : ''; ?> mb-2" type="file" id="foto" name="foto" onchange="previewFoto();">
            <div class="invalid-feedback">
              <?= $pesan_error_foto; ?>
            </div>
          
                <p style="color:red;">Max Ukuran Foto 2mb ("jpg","jpeg","png")</p>

            </div>
          <button type="submit" class="btn btn-primary btn-user btn-block" name="ubah">Simpan</button>
      </form>
    </div>
  </div>
</div>
