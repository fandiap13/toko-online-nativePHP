<?php 

$id_user = $_SESSION['user_id'];
$user = query("SELECT * FROM users WHERE `user_id` = '$id_user'")[0];

if (isset($_POST['ubahpass'])) {
	$password_sekarang = $_POST['password_sekarang'];
	$password_baru = $_POST['password_baru'];
	$password_baru2 = $_POST['password_baru2'];
	$pesan_error_pass = "";
	$pesan_error_pass2 = "";
	$pesan_error_retype = "";

	if (!password_verify($password_sekarang, $user['password'])) {
		$pesan_error_pass = "Password yang anda masukkan salah";
	}

	if ($password_baru !== $password_baru2) {
		$pesan_error_retype = "Konfirmasi password tidak sesuai";
	}

	$aturan_pass1 = preg_match('@[A-Z]@', $password_baru);
  $aturan_pass2 = preg_match('@[a-z]@', $password_baru);
  $aturan_pass3 = preg_match('@[0-9]@', $password_baru);
  if (!$aturan_pass1 || !$aturan_pass2 || !$aturan_pass3 || strlen($password_baru) < 8) {
    $pesan_error_pass2 .= "Password setidaknya harus 8 karakter dan harus memiliki huruf besar, huruf kecil, angka";
  }

	if ($pesan_error_pass == "" && $pesan_error_retype == "" && $pesan_error_pass2 == "") {
		$password = password_hash($password_baru, PASSWORD_DEFAULT);
		$query = mysqli_query($conn,"UPDATE `users` SET `password` = '$password' WHERE `user_id` = '$id_user'");

		if ($query) {
			echo "
        <script>
          setTimeout(function() {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              timer: 3200,
              text: 'Ubah password berhasil',
              confirmButtonText: 'Ok',
            });
          },10);
          window.setTimeout(function() {
            window.location.href = '?halaman=profile';
          },3000);
        </script>
      ";
		} else {
			echo "
			<script>
			alert('Ubah password gagal !');
			window.location.href = '?halaman=profile';
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
  $username = $_POST['username'];
  $nama_lengkap = $_POST['nama_lengkap'];
  $telp_user = $_POST['telp_user'];
  $email_user = $_POST['email_user'];
  $alamat_user = $_POST['alamat_user'];
  $jk_user = $_POST['jk_user'];
	$nama_fotoLama = $_POST['nama_fotolama'];
  $namaFile = $_FILES["foto"]["name"];
  $ukuran = $_FILES["foto"]["size"];
  $error = $_FILES["foto"]["error"];
  $tmp = $_FILES["foto"]["tmp_name"];
  $pesan_error_user = "";
  $pesan_error_email = "";
  $pesan_error_foto = "";

  $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
  $result_username = mysqli_num_rows($query);
  if ($username !== $user['username']) {
		if ($result_username > 0) {
			$pesan_error_user = "Username <b>$username</b> sudah digunakan <br>";
		}
	}
  $query = mysqli_query($conn, "SELECT * FROM users WHERE email_user = '$email_user'");
  $result_email = mysqli_num_rows($query);
  if ($email_user !== $user['email_user']) {
		if ($result_email > 0) {
			$pesan_error_email = "Email <b>$email_user</b> sudah digunakan <br>";
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
				unlink('../assets/img/'.$nama_fotoLama);
			}
			move_uploaded_file($tmp, '../assets/img/' .$namafoto);
		}
		
    $query = mysqli_query($conn,"UPDATE `users` SET `username` = '$username', `nama_lengkap` = '$nama_lengkap', `jk_user` = '$jk_user', `alamat_user` = '$alamat_user', `telp_user` = '$telp_user', `foto_user` = '$namafoto', `email_user` = '$email_user' WHERE `user_id` = '$id_user'");

		if ($query) {
      echo "
      <script>
        setTimeout(function() {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            timer: 2200,
            text: 'Ubah profile berhasil',
            confirmButtonText: 'Ok',
          });
        },10);
        window.setTimeout(function() {
          window.location.href = '?halaman=profile';
        },2000);
      </script>
    ";
		} else {
			echo "
			<script>
			alert('Ubah profile gagal !');
			window.location.href = '?halaman=profile';
			</script>
			";
		}
  }
  // print_r($_POST);
} else {
	$pesan_error_foto = "";
	$pesan_error_user = "";
  $username = "";
  $nama_lengkap = "";
  $telp_user = "";
  $email_user = "";
  $alamat_user = "";
  $jk_user = "";
	$pesan_error_email = "";
}

?>
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Profile</h4>
    </div>
    <div class="card-body">

		<div class="row">
			<div class="col-md-4">
					<!-- User Widget -->
        <form method="post" enctype="multipart/form-data">
						<!-- User Image -->
						<div class="image d-flex justify-content-center">
							<a href="../assets/img/<?= $user['foto_user']; ?>" class="perbesar">
								<img src="../assets/img/<?= $user['foto_user']; ?>" class="img-thumbnail img-preview mb-3" id="preview">
							</a>
						</div>
						<!-- User Name -->
						<h5 class="text-center"><?= $user['username']; ?></h5>
            <div class="form-group">
							<input type="hidden" name="nama_fotolama" value="<?= $user['foto_user']; ?>">
									<input type="file" name="foto" class="form-control-file mt-2 pt-1 <?= ($pesan_error_foto !== "") ? 'is-invalid' : ''; ?>" id="foto" onchange="previewFoto();">
									<?php if ($pesan_error_foto !== "") : ?>
										<div class="invalid-feedback">
											<?= $pesan_error_foto; ?>
										</div>
									<?php endif; ?>
						</div>
			</div>
			<div class="col-md-4">
							<h3 class="widget-header user">Edit Personal Information</h3>
								<!-- First Name -->
								<div class="form-group">
									<label for="first-name">Username</label>
									<input type="text" class="form-control <?= ($pesan_error_user !== "") ? 'is-invalid' : ''; ?>" id="first-name" name="username" value="<?= ($username !== "") ? $username : $user['username']; ?>" required>
									<?php if ($pesan_error_user !== "") : ?>
										<div class="invalid-feedback">
											<?= $pesan_error_user; ?>
										</div>
									<?php endif; ?>
								</div>
								<!-- Last Name -->
								<div class="form-group">
									<label for="last-name">Nama Lengkap</label>
									<input type="text" class="form-control" id="last-name" name="nama_lengkap" value="<?= ($nama_lengkap !== "") ? $nama_lengkap : $user['nama_lengkap']; ?>" required>
								</div>

								<!-- email -->
								<div class="form-group">
									<label for="email">E-mail</label>
									<input type="email" class="form-control <?= ($pesan_error_email !== "") ? 'is-invalid' : ''; ?>" id="email" name="email_user" value="<?= ($email_user !== "") ? $email_user : $user['email_user']; ?>" required>
									<?php if ($pesan_error_email !== "") : ?>
										<div class="invalid-feedback">
											<?= $pesan_error_email; ?>
										</div>
									<?php endif; ?>
								</div>

								<!-- JK -->
								<div class="form-group">
									<label for="jk">Jenis Kelamin</label>
									<select name="jk_user" id="jk" class="form-control">
                    <option value="Laki-laki" <?= ($user['jk_user'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?= ($user['jk_user'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                  </select>
								</div>
								<!-- Comunity Name -->
								<div class="form-group">
									<label for="comunity-name">No. Telp</label>
									<input type="number" class="form-control" id="comunity-name" name="telp_user" value="<?= ($telp_user !== "") ? $telp_user : $user['telp_user']; ?>" required>
								</div>
								
                <!-- alamat -->
								<div class="form-group">
									<label for="alamat">Alamat</label>
                  <textarea name="alamat_user" class="form-control" id="alamat" cols="30" rows="4" required><?= ($alamat_user !== "") ? $alamat_user : $user['alamat_user']; ?></textarea>
								</div>

								<!-- Submit button -->
								<button class="btn btn-primary" name="simpan">Simpan Perubahan</button>
				</form>
					</div>

					<div class="col-md-4">
						<h3 class="widget-header user">Edit Password</h3>
						<form method="POST">
							<!-- Current Password -->
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
							<button class="btn btn-primary" name="ubahpass">Ubah Password</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
