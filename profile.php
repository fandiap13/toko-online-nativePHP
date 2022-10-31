<?php 

$title = 'Profile';
include "template/header.php";

loginpengunjung();

if (isset($_POST['ubahpass'])) {
	$id_pembeli = $_POST['id_pembeli2'];
	$password_sekarang = $_POST['password_sekarang'];
	$password_baru = $_POST['password_baru'];
	$password_baru2 = $_POST['password_baru2'];
	$pesan_error_pass = "";
	$pesan_error_pass2 = "";
	$pesan_error_retype = "";

	if (!password_verify($password_sekarang, $pembeli['password_pembeli'])) {
		$pesan_error_pass .= "Password yang anda masukkan salah";
	}

	$aturan_pass1 = preg_match('@[A-Z]@', $password_baru);
  $aturan_pass2 = preg_match('@[a-z]@', $password_baru);
  $aturan_pass3 = preg_match('@[0-9]@', $password_baru);

  if (!$aturan_pass1 || !$aturan_pass2 || !$aturan_pass3 || strlen($password_baru) < 8) {
    $pesan_error_pass2 .= "Password setidaknya harus 8 karakter dan harus memiliki huruf besar, huruf kecil, angka";
  }

	if ($password_baru !== $password_baru2) {
		$pesan_error_retype = "Konfirmasi password tidak sesuai";
	}

	if ($pesan_error_pass == "" && $pesan_error_retype == "" && $pesan_error_pass2 == "") {
		$password = password_hash($password_baru, PASSWORD_DEFAULT);
		$query = mysqli_query($conn,"UPDATE `pembeli` SET `password_pembeli` = '$password' WHERE `pembeli`.`id_pembeli` = '$id_pembeli'");

		if ($query) {
			echo "
			<script>
			alert('Ubah password berhasil');
			window.location.href = 'profile.php';
			</script>
			";
		} else {
			echo "
			<script>
			alert('Ubah password gagal !');
			window.location.href = 'profile.php';
			</script>
			";
		}
	}

} else {
	$pesan_error_pass = "";
	$pesan_error_pass2 = "";
	$pesan_error_retype = "";
}

if (isset($_POST['simpan'])) {
  $id_pembeli = $_POST['id_pembeli'];
  $username_pembeli = $_POST['username_pembeli'];
  $nama_pembeli = $_POST['nama_pembeli'];
  $telp_pembeli = $_POST['telp_pembeli'];
  $email_pembeli = $_POST['email_pembeli'];
  $alamat_pembeli = $_POST['alamat_pembeli'];
  $jk_pembeli = $_POST['jk_pembeli'];
	$nama_fotoLama = $_POST['nama_fotolama'];
  $namaFile = $_FILES["foto"]["name"];
  $ukuran = $_FILES["foto"]["size"];
  $error = $_FILES["foto"]["error"];
  $tmp = $_FILES["foto"]["tmp_name"];
  $pesan_error_user = "";
  $pesan_error_foto = "";
  $pesan_error_email = "";

  $query = mysqli_query($conn, "SELECT * FROM pembeli WHERE username_pembeli = '$username_pembeli'");
  $result_username = mysqli_num_rows($query);
  if ($username_pembeli !== $pembeli['username_pembeli']) {
		if ($result_username > 0) {
			$pesan_error_user = "Username <b>$username_pembeli</b> sudah digunakan <br>";
		}
	}
  $query = mysqli_query($conn, "SELECT * FROM pembeli WHERE email_pembeli = '$email_pembeli'");
  $result_email = mysqli_num_rows($query);
  if ($email_pembeli !== $pembeli['email_pembeli']) {
		if ($result_email > 0) {
			$pesan_error_email = "E-mail <b>$email_pembeli</b> sudah digunakan <br>";
		}
	}

  // foto
  if ($error === 4) {
    $namafoto = $nama_fotoLama;
  } else {
    $gambarvalid = ["jpg","jpeg","png"];
    $ekstensigambar = explode('.', $namaFile);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if (!in_array($ekstensigambar, $gambarvalid)) {
      $pesan_error_foto = "Yang anda upload bukan gambar !";
    }
    if ($ukuran > 2000000) {
      $pesan_error_foto = "Ukuran gambar terlalu besar !";
    }
    $namafoto = uniqid();
    $namafoto .= '.';
    $namafoto .= $ekstensigambar;
  }

  if ($pesan_error_user == "" && $pesan_error_foto == "" && $pesan_error_email == ""){
		if ($error !== 4) {
			if ($nama_fotoLama !== 'default.svg') {
				unlink('assets/img/'.$nama_fotoLama);
			}
			move_uploaded_file($tmp, 'assets/img/' .$namafoto);
		}
		
    $query = mysqli_query($conn,"UPDATE `pembeli` SET `username_pembeli` = '$username_pembeli', `nama_pembeli` = '$nama_pembeli', `jk_pembeli` = '$jk_pembeli', `alamat_pembeli` = '$alamat_pembeli', `telp_pembeli` = '$telp_pembeli', `foto_pembeli` = '$namafoto', `email_pembeli` = '$email_pembeli' WHERE `pembeli`.`id_pembeli` = '$id_pembeli'");

		if ($query) {
			echo "
			<script>
			alert('Ubah profile berhasil');
			window.location.href = 'profile.php';
			</script>
			";
		} else {
			echo "
			<script>
			alert('Ubah profile gagal !');
			window.location.href = 'profile.php';
			</script>
			";
		}
  }
} else {
	$pesan_error_foto = "";
	$pesan_error_email = "";
	$pesan_error_user = "";
  $username_pembeli = "";
  $nama_pembeli = "";
  $telp_pembeli = "";
  $email_pembeli = "";
  $alamat_pembeli = "";
  $jk_pembeli = "";
}

?>

<section class="user-profile section">
	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0">
				<div class="sidebar">
					<!-- User Widget -->
        <form method="post" enctype="multipart/form-data">
				<div class="widget user">
						<!-- User Image -->
						<div class="image d-flex justify-content-center">
							<a href="assets/img/<?= $pembeli['foto_pembeli']; ?>" class="perbesar">
								<img src="assets/img/<?= $pembeli['foto_pembeli']; ?>" class="img-thumbnail img-preview mb-3" id="preview">
							</a>
						</div>
						<!-- User Name -->
						<h5 class="text-center"><?= $pembeli['username_pembeli']; ?></h5>
            <div class="form-group">
							<input type="hidden" name="nama_fotolama" value="<?= $pembeli['foto_pembeli']; ?>">
									<input type="file" name="foto" class="form-control-file mt-2 pt-1 <?= ($pesan_error_foto !== "") ? 'is-invalid' : ''; ?>" id="foto" onchange="previewFoto();">
									<?php if ($pesan_error_foto !== "") : ?>
										<div class="invalid-feedback">
											<?= $pesan_error_foto; ?>
										</div>
									<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-10 offset-md-1 col-lg-9 offset-lg-0">
				<!-- Edit Profile Welcome Text -->
				<div class="widget welcome-message">
					<h2>Edit profile</h2>
				</div>
				<!-- Edit Personal Info -->
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="widget personal-info">
							<h3 class="widget-header user">Edit Personal Information</h3>
                <input type="hidden" name="id_pembeli" value="<?= $pembeli['id_pembeli']; ?>">
								<!-- First Name -->
								<div class="form-group">
									<label for="first-name">Username</label>
									<input type="text" class="form-control <?= ($pesan_error_user !== "") ? 'is-invalid' : ''; ?>" id="first-name" name="username_pembeli" value="<?= ($username_pembeli !== "") ? $username_pembeli : $pembeli['username_pembeli']; ?>" required>
									<?php if ($pesan_error_user !== "") : ?>
										<div class="invalid-feedback">
											<?= $pesan_error_user; ?>
										</div>
									<?php endif; ?>
								</div>
								<!-- Last Name -->
								<div class="form-group">
									<label for="last-name">Nama Lengkap</label>
									<input type="text" class="form-control" id="last-name" name="nama_pembeli" value="<?= ($nama_pembeli !== "") ? $nama_pembeli : $pembeli['nama_pembeli']; ?>" required>
								</div>

								<!-- email -->
								<div class="form-group">
									<label for="email">E-mail</label>
									<input type="email" class="form-control <?= ($pesan_error_email !== "") ? 'is-invalid' : ''; ?>" id="email" name="email_pembeli" value="<?= ($email_pembeli !== "") ? $email_pembeli : $pembeli['email_pembeli']; ?>" required>
									<?php if ($pesan_error_email !== "") : ?>
										<div class="invalid-feedback">
											<?= $pesan_error_email; ?>
										</div>
									<?php endif; ?>
								</div>

								<!-- JK -->
								<div class="form-group">
									<label for="jk">Jenis Kelamin</label>
									<select name="jk_pembeli" id="jk" class="form-control">
                    <option value="Laki-laki" <?= ($pembeli['jk_pembeli'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?= ($pembeli['jk_pembeli'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                  </select>
								</div>
								<!-- Comunity Name -->
								<div class="form-group">
									<label for="comunity-name">No. Telp</label>
									<input type="number" class="form-control" id="comunity-name" name="telp_pembeli" value="<?= ($telp_pembeli !== "") ? $telp_pembeli : $pembeli['telp_pembeli']; ?>" required>
								</div>

                <!-- alamat -->
								<div class="form-group">
									<label for="alamat">Alamat</label>
                  <textarea name="alamat_pembeli" class="form-control" id="alamat" cols="30" rows="4" required><?= ($alamat_pembeli !== "") ? $alamat_pembeli : $pembeli['alamat_pembeli']; ?></textarea>
								</div>

								<!-- Submit button -->
								<button class="btn btn-transparent" name="simpan" onclick="return confirm('Apakah anda yakin mengubah profile ?');">Simpan Perubahan</button>
				</form>
						</div>
					</div>

					<div class="col-lg-6 col-md-6">
						<!-- Change Password -->
					<div class="widget change-password">
						<h3 class="widget-header user">Edit Password</h3>
						<form method="POST">
							<!-- Current Password -->
							<input type="hidden" name="id_pembeli2" value="<?= $pembeli['id_pembeli']; ?>">
							<div class="form-group">
								<label for="current-password">Password Saat Ini</label>
								<input type="password" class="form-control <?= ($pesan_error_pass !== "") ? 'is-invalid' : ''; ?>" id="current-password" name="password_sekarang" required>
								<?php if ($pesan_error_pass !== "") : ?>
										<div class="invalid-feedback">
											<?= $pesan_error_pass; ?>
										</div>
								<?php endif; ?>
							</div>
							<!-- New Password -->
							<div class="form-group">
								<label for="new-password">Password Baru</label>
								<input type="password" class="form-control <?= ($pesan_error_pass2 !== "") ? 'is-invalid' : ''; ?>" id="new-password" name="password_baru" required>
								<?php if ($pesan_error_pass2 !== "") : ?>
										<div class="invalid-feedback">
											<?= $pesan_error_pass2; ?>
										</div>
								<?php endif; ?>
							</div>
							<!-- Confirm New Password -->
							<div class="form-group">
								<label for="confirm-password">Konfirmasi Password Baru</label>
								<input type="password" class="form-control <?= ($pesan_error_retype !== "") ? 'is-invalid' : ''; ?>" id="confirm-password" name="password_baru2" required>
								<?php if ($pesan_error_retype !== "") : ?>
										<div class="invalid-feedback">
											<?= $pesan_error_retype; ?>
										</div>
								<?php endif; ?>
							</div>
							<!-- Submit Button -->
							<button class="btn btn-transparent" name="ubahpass">Ubah Password</button>
						</form>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include "template/footer.php"; ?>