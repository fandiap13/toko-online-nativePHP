<?php 

if (isset($_POST['tambah'])) {
    $nama_produk =  htmlentities(strip_tags(trim($_POST['nama_produk'])));
    $id_jenis =  htmlentities(strip_tags(trim($_POST['id_jenis'])));
    $tgl_post =  date('Y-m-d H:i:s');
    $berat_produk =  htmlentities(strip_tags(trim($_POST['berat_produk'])));
    $harga_produk =  htmlentities(strip_tags(trim($_POST['harga_produk'])));
    $status_produk =  htmlentities(strip_tags(trim($_POST['status_produk'])));
    $deskripsi_produk =  $_POST['deskripsi_produk'];
    $namaFile = $_FILES["foto"]["name"];
    $ukuran = $_FILES["foto"]["size"];
    $error = $_FILES["foto"]["error"];
    $tmp = $_FILES["foto"]["tmp_name"];
    $pesan_error_foto = "";

    // print_r($_POST);
    // print_r($_FILES);

    $gambarvalid = ["jpg","jpeg","png"];
    $ekstensigambar = explode('.', $namaFile[0]);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if (!in_array($ekstensigambar, $gambarvalid)) {
      $pesan_error_foto = "Yang anda upload bukan gambar";
    }
    if ($ukuran[0] > 5000000) {
      $pesan_error_foto = "Ukuran gambar terlalu besar";
    }
    
    $namafoto = date('is');
    $namafoto .= '_';
    $namafoto .= $namaFile[0];

    if ($pesan_error_foto == "") {
      $query = mysqli_query($conn,"INSERT INTO `produk` (`id_produk`, `nama_produk`, `id_jenis`, `tgl_post`, `berat_produk`, `harga_produk`, `deskripsi_produk`, `status_produk`, `foto_produk`) VALUES (NULL, '$nama_produk', '$id_jenis', '$tgl_post', '$berat_produk', '$harga_produk', '$deskripsi_produk', '$status_produk', '$namafoto')");
      

      // mendapat id produk
      $tampil_id = query("SELECT * FROM produk ORDER BY id_produk DESC")[0];

      $id_produk_barusan = $tampil_id['id_produk'];
      foreach ($namaFile as $key => $tiap_nama) {
        $tiap_lokasi = $tmp[$key];
        $gambarvalid = ["jpg","jpeg","png"];
        $ekstensigambar = explode('.', $tiap_nama);
        $ekstensigambar = strtolower(end($ekstensigambar));
        // if (!in_array($ekstensigambar, $gambarvalid)) {
        //   $pesan_error_foto2 = "Yang anda upload bukan gambar";
        // }
        // if ($ukuran[$key] > 2000000) {
        //   $pesan_error_foto2 = "Ukuran gambar terlalu besar";
        // }

        $namafoto = date('is');
        $namafoto .= '_';
        $namafoto .= $tiap_nama;

        // if ($pesan_error_foto2 == "") {
          move_uploaded_file($tiap_lokasi, '../assets/img/produk/' .$namafoto);

          mysqli_query($conn, "INSERT INTO `foto_produk` (`id_foto_produk`, `id_produk`, `nama_foto_produk`) VALUES (NULL, '$id_produk_barusan', '$namafoto')");
        // }
      }

      echo "
      <script>
        setTimeout(function() {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            timer: 2200,
            text: 'Produk $nama_produk berhasil ditambahkan',
            confirmButtonText: 'Ok',
          });
        },10);
        window.setTimeout(function() {
          window.location.href = '?halaman=produk';
        },2000);
      </script>
    ";
    }

    // }

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
      <h4 class="m-0 font-weight-bold">Tambah Produk</h4>
    </div>
    <div class="card-body">
    <form method="post" enctype="multipart/form-data" id="form-tambah">
            <div class="mb-3">
              <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Masukkan Nama Produk..." value="<?= $nama_produk; ?>" required autofocus>
            </div>

            <div class="mb-3">
              <label for="id_jenis" class="form-label">Kategori Produk</label>
                <select name="id_jenis" class="form-control" id="id_jenis">
                  <?php 
                  $produk = query("SELECT * FROM jenis"); 
                  foreach ($produk as $p) :
                  ?>
                    <option value="<?= $p['id_jenis']; ?>" <?= ($id_jenis == $p['id_jenis']) ? 'selected' : ''; ?>><?= $p['jenis']; ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
              <label for="berat_produk" class="form-label">Berat Produk (Gr)</label>
              <input type="number" class="form-control" id="berat_produk" name="berat_produk" placeholder="Masukkan Berat Produk..." value="<?= $berat_produk; ?>" required>
            </div>

            <div class="mb-3">
              <label for="harga_produk" class="form-label">Harga Produk (Rp)</label>
              <input type="number" class="form-control" id="harga_produk" name="harga_produk" placeholder="Masukkan Harga Produk..." value="<?= $harga_produk; ?>" required>
            </div>

            <div class="mb-3">
              <label for="status_produk" class="form-label">Status Produk</label>
              <select name="status_produk" id="status_produk" class="form-control">
                <option value="Tersedia" <?= ($status_produk == "Tersedia") ? 'selected' : ''; ?>>Tersedia</option>
                <option value="Tidak tersedia" <?= ($status_produk == "Tidak tersedia") ? 'selected' : ''; ?>>Tidak tersedia</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="" class="form-label">Deskripsi Produk</label>
                <textarea name="deskripsi_produk" id="textarea" rows="5" class="form-control hapustext textarea1" required><?= $deskripsi_produk; ?></textarea>
            </div>

          <div class="mb-3">
            <label for="foto" class="form-label">Foto Produk</label>
            <br>
  
            <input class="form-control <?= ($pesan_error_foto !== "") ? 'is-invalid' : ''; ?> mb-2" type="file" id="foto" name="foto[]" required>
            <div class="invalid-feedback">
              <?= $pesan_error_foto; ?>
            </div>
                <div class="letak-input mb-2">
                </div>
                <p style="color:red;">Max Ukuran Foto 2mb ("jpg","jpeg","png")</p>
                <button type="button" class="btn btn-primary btn-tambah"> <i class="fa fa-plus"></i> Tambah Foto</button> 
            </div>
          <button type="submit" class="btn btn-primary btn-user btn-block" name="tambah">Tambah</button>
      </form>
    </div>
  </div>
</div>



<script>
  $('.btn-tambah').click(function (e) {
    e.preventDefault();
    $('.letak-input').append(`<div class="row mb-2" id="hapus">
        <div class="col-md-8">
          <input class="form-control" type="file" id="foto" name="foto[]" required>
        </div>
        <div class="col-md-4">
          <button type ="button" class="btn btn-danger btn-hapus"><i class="fa fa-trash"></i></button>
        </div>
      </div>`);
  });
  
  $(document).on('click','.btn-hapus',function(e){
    e.preventDefault();
    // hapus formtambah parentnya <tr>
    $(this).parents('#hapus').remove();
});

</script>