<?php 

include "function.php";

if (isset($_SESSION['login'])) {
  header('location: index.php');
}

if (isset($_POST['registrasi'])) {
  $username_pembeli = $_POST['username_pembeli'];
  $password_pembeli = $_POST['password_pembeli'];
  $password_pembeli2 = $_POST['password_pembeli2'];
  $nama_pembeli = $_POST['nama_pembeli'];
  $telp_pembeli = $_POST['telp_pembeli'];
  $email_pembeli = $_POST['email_pembeli'];
  $alamat_pembeli = $_POST['alamat_pembeli'];
  $jk_pembeli = $_POST['jk_pembeli'];
  $namaFile = $_FILES["foto"]["name"];
  $ukuran = $_FILES["foto"]["size"];
  $error = $_FILES["foto"]["error"];
  $tmp = $_FILES["foto"]["tmp_name"];
  $pesan_error_user = "";
  $pesan_error_email = "";
  $pesan_error_foto = "";
  $pesan_error_password = "";
  $aturan_error = "";
  $suksess = "";

  $query = mysqli_query($conn, "SELECT * FROM pembeli WHERE username_pembeli = '$username_pembeli'");
  $result_username = mysqli_num_rows($query);
	if ($result_username > 0) {
		$pesan_error_user = "Username <b>$username_pembeli</b> sudah digunakan <br>";
	}

  $query = mysqli_query($conn, "SELECT * FROM pembeli WHERE email_pembeli = '$email_pembeli'");
  $result_email = mysqli_num_rows($query);
	if ($result_email > 0) {
		$pesan_error_email = "E-mail <b>$email_pembeli</b> sudah digunakan <br>";
	}
  

  if ($password_pembeli !== $password_pembeli2) {
    $pesan_error_password .= "Retype password tidak sesuai";
  }

  $aturan_pass1 = preg_match('@[A-Z]@', $password_pembeli);
  $aturan_pass2 = preg_match('@[a-z]@', $password_pembeli);
  $aturan_pass3 = preg_match('@[0-9]@', $password_pembeli);

  if (!$aturan_pass1 || !$aturan_pass2 || !$aturan_pass3 || strlen($password_pembeli) < 8) {
    $aturan_error .= "Password setidaknya harus 8 karakter dan harus memiliki huruf besar, huruf kecil, angka";
  }

  // foto
  if ($error === 4) {
    $namafoto = 'default.svg';
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

  if ($pesan_error_user == "" && $pesan_error_foto == "" && $pesan_error_password == "" && $aturan_error == "" && $pesan_error_email == ""){
    if ($error !== 4) {
			move_uploaded_file($tmp, 'assets/img/' .$namafoto);
		}

    $status_daftar = md5(rand(0,1000));
    $password = password_hash($password_pembeli, PASSWORD_DEFAULT);
    $query = mysqli_query($conn,"INSERT INTO `pembeli` (`id_pembeli`, `username_pembeli`, `password_pembeli`, `nama_pembeli`, `jk_pembeli`, `alamat_pembeli`, `telp_pembeli`, `foto_pembeli`, `email_pembeli`, `status_pendaftaran`) VALUES (NULL, '$username_pembeli', '$password', '$nama_pembeli', '$jk_pembeli', '$alamat_pembeli', '$telp_pembeli', '$namafoto', '$email_pembeli','$status_daftar')");

		if ($query) {
      $judul_email = "Halaman Konfirmasi Pendaftaran";
      $isi_email = "Akun yang kamu miliki dengan E-mail <b>$email_pembeli</b> telah siap digunakan, silahkan melakukan aktifasi E-mail dengan cara klik link di bawah ini: <br>";
      $isi_email .= $lokasi."/verifikasi.php?email=$email_pembeli&token=$status_daftar";
      $proses_berhasil = "Proses registrasi berhasil silahkan cek E-mail anda <b>$email_pembeli</b>";

      $suksess = email($email_pembeli, $judul_email, $isi_email, $proses_berhasil);
		}
  }

} else {
  $pesan_error_user = "";
  $pesan_error_email = "";
  $pesan_error_foto = "";
  $pesan_error_password = "";
  $aturan_error = "";
  $password_pembeli = "";
  $username_pembeli = "";
  $nama_pembeli = "";
  $telp_pembeli = "";
  $email_pembeli = "";
  $alamat_pembeli = "";
  $jk_pembeli = "";
  $suksess = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi Pengunjung</title>
  
  <!-- FAVICON -->
  <link href="assets/img/favicon.png" rel="shortcut icon">
  <!-- PLUGINS CSS STYLE -->
  <!-- <link href="assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"> -->
  <!-- Bootstrap -->
  <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap-slider.css">
  <!-- Font Awesome -->
  <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Owl Carousel -->
  <link href="assets/plugins/slick-carousel/slick/slick.css" rel="stylesheet">
  <link href="assets/plugins/slick-carousel/slick/slick-theme.css" rel="stylesheet">
  <!-- Fancy Box -->
  <link href="assets/plugins/fancybox/jquery.fancybox.pack.css" rel="stylesheet">
  <link href="assets/plugins/jquery-nice-select/css/nice-select.css" rel="stylesheet">
  <!-- CUSTOM CSS -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body class="body-wrapper">

<section class="login py-5 border-top-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 align-item-center">
                <div class="border">
                    <h3 class="bg-gray p-4">Registrasi</h3>

                    
                    <form method="POST" enctype="multipart/form-data">
                      <fieldset class="p-4">
                        <?php if ($suksess !== "") : ?>
                            <div class="alert alert-success">
                              <?= $suksess; ?>
                            </div>
                          <?php endif; ?>
                      
                      <div class="form-group">
                        <input type="text" class="form-control <?= ($pesan_error_user !== "") ? 'is-invalid' : ''; ?>" id="first-name" name="username_pembeli" value="<?= $username_pembeli; ?>" placeholder="Username" required>
                        <?php if ($pesan_error_user !== "") : ?>
                          <div class="invalid-feedback">
                            <?= $pesan_error_user; ?>
                          </div>
                        <?php endif; ?>
                      </div>

                          <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user <?= ($aturan_error !== "") ? 'is-invalid' : ''; ?>" id="password" placeholder="Password..." name="password_pembeli" value="" required>    
                                <?php if ($aturan_error !== "") : ?>
                                  <div class="invalid-feedback">
                                    <?= $aturan_error; ?>
                                  </div>
                                <?php endif; ?>                    
                              </div>
                              <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user <?= ($pesan_error_password !== "") ? 'is-invalid' : ''; ?>" id="password2" placeholder="Repeat Password..." name="password_pembeli2" value="" required>
                                <?php if ($pesan_error_password !== "") : ?>
                                  <div class="invalid-feedback">
                                    <?= $pesan_error_password; ?>
                                  </div>
                                <?php endif; ?>
                              </div>
                          </div>

                            <input type="text" placeholder="Nama Lengkap" class="border p-3 w-100 my-2" name="nama_pembeli" value="<?= $nama_pembeli; ?>" required>

                            <div class="mb-3">
                              <label for="jk_pembeli" class="form-label">Jenis Kelamin</label>
                                <select name="jk_pembeli" class="form-control" id="jk_pembeli">
                                  <option value="Laki-laki <?= ($jk_pembeli == 'Laki-laki') ? 'selected' : ''; ?>">Laki-laki</option>
                                  <option value="Perempuan" <?= ($jk_pembeli == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                            <input type="email" placeholder="E-mail" class="form-control <?= ($pesan_error_email !== "") ? 'is-invalid' : ''; ?>" name="email_pembeli" value="<?= $email_pembeli; ?>" required>
                            <?php if ($pesan_error_email !== "") : ?>
                                  <div class="invalid-feedback">
                                    <?= $pesan_error_email; ?>
                                  </div>
                                <?php endif; ?>
                            </div>

                            <input type="number" placeholder="No. Telp" class="border p-3 w-100 my-2" name="telp_pembeli" value="<?= $telp_pembeli; ?>" required>

                            <textarea name="alamat_pembeli" id="" cols="30" rows="10"  class="border p-3 w-100 my-2" placeholder="Alamat"><?= $alamat_pembeli; ?></textarea>

                            <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <br>
                              <img src="assets/img/default.svg" class="img-thumbnail img-preview mb-3" id="preview" style="height: 150px;">
                                  <input class="form-control <?= ($pesan_error_foto !== "") ? 'is-invalid' : ''; ?>" type="file" id="foto" name="foto" onchange="previewFoto()">
                                  <?php if ($pesan_error_foto !== "") : ?>
                                    <div class="invalid-feedback">
                                      <?= $pesan_error_foto; ?>
                                    </div>
                                  <?php endif; ?>
                            </div>

                            <button type="submit" class="d-block py-3 px-5 bg-primary text-white border-0 rounded font-weight-bold mt-3" name="registrasi">Registrasi</button>

                            <a class="mt-3 d-block text-primary" href="index.php">Kembali ke beranda</a>
                            <a class="mt-3 d-inline-block text-primary" href="login.php">Sudah punya akun? Log In!</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JAVASCRIPTS -->
<script src="assets/plugins/jQuery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap-slider.js"></script>
  <!-- tether js -->
<script src="assets/plugins/tether/js/tether.min.js"></script>
<script src="assets/plugins/raty/jquery.raty-fa.js"></script>
<script src="assets/plugins/slick-carousel/slick/slick.min.js"></script>
<script src="assets/plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<script src="assets/plugins/fancybox/jquery.fancybox.pack.js"></script>
<script src="assets/plugins/smoothscroll/SmoothScroll.min.js"></script>
<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU&libraries=places"></script>
<script src="assets/plugins/google-map/gmap.js"></script>
<script src="assets/js/script.js"></script>


<!-- Page level plugins -->
<script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
<script src="assets/js/demo/datatables-demo.js"></script>
</body>

<script>
  function previewFoto(){
      const foto = document.querySelector('#foto');
      const imgPreview = document.querySelector('.img-preview');

      const fileFoto = new FileReader();
      fileFoto.readAsDataURL(foto.files[0]);
      fileFoto.onload = function(e) {
      imgPreview.src = e.target.result;
      }
    }
</script>

</html>