<?php 

$id = $_GET['id'];
$toko = query("SELECT * FROM toko")[0];

if (isset($_POST['ubah'])) {
  $tentang_kami = $_POST['tentang_kami'];
  $telp = $_POST['telp'];
  $email = $_POST['email'];
  $alamat = $_POST['alamat'];
  $pesan_error_foto = "";
  $foto_lama =  $_POST['foto_lama'];
  $namaFile = $_FILES["foto"]["name"];
  $ukuran = $_FILES["foto"]["size"];
  $error = $_FILES["foto"]["error"];
  $tmp = $_FILES["foto"]["tmp_name"];
  $pesan_error_foto = "";

    // foto
    if ($error === 4) {
      $namafoto = $foto_lama;
    } else {
      $gambarvalid = ["jpg","jpeg","png"];
      $ekstensigambar = explode('.', $namaFile);
      $ekstensigambar = strtolower(end($ekstensigambar));
      if (!in_array($ekstensigambar, $gambarvalid)) {
        $pesan_error_foto = "Yang anda upload bukan gambar";
      }
      if ($ukuran > 2000000) {
        $pesan_error_foto = "Ukuran gambar terlalu besar";
      }
      $namafoto = uniqid();
      $namafoto .= '.';
      $namafoto .= $ekstensigambar;
    }
      
  if ($pesan_error_foto == "") {
    if ($error !== 4) {
      unlink('../assets/img/toko/'.$foto_lama);
      move_uploaded_file($tmp, '../assets/img/toko/' .$namafoto);
    }

    $query = mysqli_query($conn,"UPDATE `toko` SET `tentang_kami` = '$tentang_kami', `telp` = '$telp', `email` = '$email', `alamat` = '$alamat', `foto` = '$namafoto' WHERE `toko`.`id` = '$id'");

    if ($query) {
      echo "
        <script>
          setTimeout(function() {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              timer: 2200,
              text: 'Data toko berhasil diubah',
              confirmButtonText: 'Ok',
            });
          },10);
          window.setTimeout(function() {
            window.location.href = '?halaman=toko';
          },2000);
        </script>
      ";
    }
  }

} else {
  $tentang_kami = "";
  $telp = "";
  $email = "";
  $alamat = "";
  $pesan_error_foto = "";
}

?>

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Edit Data Toko</h4>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="foto_lama" value="<?= $toko['foto']; ?>">

      <div class="form-group">
        <label for="foto" class="form-label">Foto Toko</label>
        <br>
        <div class="row">
          <div class="col-md-4">
            <img src="../assets/img/toko/<?= $toko['foto']; ?>" class="img-thumbnail img-preview mb-3" id="preview" style="height: 180px;">
          </div>
          <div class="col-md-8">
            <input class="form-control <?= ($pesan_error_foto !== "") ? 'is-invalid' : ''; ?>" type="file" id="foto" name="foto" onchange="previewFoto()">
            <?php if($pesan_error_foto !== "") : ?>
              <div class="invalid-feedback">
                <?= $pesan_error_foto; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="form-group">
      <label for="tentang_kami" class="form-label">Tentang Kami</label>
        <textarea name="tentang_kami" id="textarea" cols="30" rows="15" class="form-control" required><?= ($tentang_kami !== "") ? $tentang_kami : $toko['tentang_kami']; ?></textarea>
      </div>

      <div class="form-group">
      <label for="telp" class="form-label">No. Telp</label>
        <input type="number" name="telp" class="form-control" value="<?= ($telp !== "") ? $telp : $toko['telp']; ?>" required>
      </div>

      <div class="form-group">
      <label for="email" class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" value="<?= ($email !== "") ? $email : $toko['email']; ?>" required>
      </div>

      <div class="form-group">
      <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" id="alamat" cols="30" rows="5" class="form-control" required><?= ($alamat !== "") ? $alamat : $toko['alamat']; ?></textarea>
      </div>
  
      <button type="submit" name="ubah" class="btn btn-primary btn-user btn-block">Simpan Data</button>
      </form>
    </div>
  </div>
</div>
