<?php 

$title = 'Konfirmasi Pembayaran';
include "template/header.php";

loginpengunjung();

$id_transaksi = $_GET['id'];
$trans = query("SELECT * FROM pembelian WHERE id_pembelian = '$id_transaksi'")[0];
$id_pembeli_transaksi = $trans['id_pembeli'];
$id_pembeli = $_SESSION['id_pembeli'];
$total_pembelian = $trans['total_pembelian'];

if ($id_pembeli !== $id_pembeli_transaksi) {
  echo "
  <script>
  alert('Jangan Nakal Kamu Ya !');
  window.location.href = 'transaksi.php';
  </script>
  ";
}

$query = mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pembelian = '$id_transaksi'");
$cekpembayaran = mysqli_num_rows($query);
if ($cekpembayaran > 0) {
  echo "
    <script>
    alert('Anda sudah mengirimkan bukti pembayaran pada transaksi $id_transaksi');
    window.location.href = 'transaksi.php';
    </script>
    ";
}

if (isset($_POST['kirim'])) {
  $bank = $_POST['bank'];
  $jumlah = $_POST['jumlah'];
  $tgl = date('Y-m-d H:i:s');
  $namaFile = $_FILES["bukti_pembayaran"]["name"];
  $ukuran = $_FILES["bukti_pembayaran"]["size"];
  $error = $_FILES["bukti_pembayaran"]["error"];
  $tmp = $_FILES["bukti_pembayaran"]["tmp_name"];
  $status_pembelian = 1;
  $pesan_error_foto = "";

  // foto
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

  if ($pesan_error_foto == ""){
    move_uploaded_file($tmp, 'assets/img/bukti/' .$namafoto);

    mysqli_query($conn,"INSERT INTO `pembayaran` (`id_pembayaran`, `id_pembelian`, `bank`, `jumlah`, `tanggal`, `bukti`) VALUES (NULL, '$id_transaksi', '$bank', '$jumlah', '$tgl', '$namafoto')");

    mysqli_query($conn,"UPDATE `pembelian` SET `status_pembelian` = '$status_pembelian' WHERE `pembelian`.`id_pembelian` = '$id_transaksi'");

    echo "
    <script>
    alert('Terimakasih sudah mengirimkan bukti pembayaran');
    window.location.href = 'transaksi.php';
    </script>
    ";
  }

} else {
  $pesan_error_foto = "";
  $jumlah = "";
  $bank = "";
}

?>

<section class="user-profile section">
	<div class="container">
		<div class="row">
			<div class="col">
				<!-- Edit Profile Welcome Text -->
				<div class="widget welcome-message">
					<h2>Konfirmasi Pembayaran</h2>
					<p>Kirim bukti pembayaran anda disini</p>
          <div class="alert alert-success" role="alert">
            Silahkan melakukan pembayaran <b>Rp. <?= number_format($total_pembelian); ?></b> ke Bank 
            <b></b>
          </div>
				</div>
						<div class="widget personal-info">
							<form method="POST" enctype="multipart/form-data">
              
              <?php if($pesan_error_foto !== "") : ?>
                <div class="alert alert-danger" role="alert">
                  <?= $pesan_error_foto; ?>
                </div>
              <?php endif; ?>

								<div class="form-group">
									<label class="form-label">ID Transaksi</label>
									<input type="text" class="form-control" value="<?= $id_transaksi; ?>" required readonly>
								</div>
								<div class="form-group">
									<label class="form-label">Nama Pembeli</label>
									<input type="text" class="form-control" value="<?= $pembeli['nama_pembeli']; ?>" readonly required>
								</div>
								<div class="form-group">
									<label class="form-label">Masukkan Nama Bank</label>
                  <input type="text" class="form-control" name="bank" value="<?= $bank; ?>" required>
								</div>
                <div class="form-group">
									<label class="form-label">Jumlah (Rp)</label>
									<input type="number" class="form-control" name="jumlah" value="<?= $jumlah; ?>" required>
								</div>
								<!-- File chooser -->
								<div class="form-group">
                  <label class="form-label">Bukti Pembayaran</label><br>
                  <img src="assets/img/default.svg" class="img-thumbnail img-preview mb-3" id="preview" style="height: 180px;">
									<input type="file" name="bukti_pembayaran" class="form-control-file mt-2 pt-1" id="foto" onchange="previewFoto();" required>
                  <p style="color: red;">Foto bukti harus jpg, jpeg, png Max 2 mb</p>
								</div>
								<!-- Submit button -->
								<button class="btn btn-transparent" name="kirim" onclick="return confirm('Apakah data sudah benar ?');">Kirim</button>
							</form>
						</div>
			</div>
		</div>
	</div>
</section>

<?php include "template/footer.php"; ?>