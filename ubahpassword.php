<?php 

include "function.php";

if (isset($_SESSION['login'])) {
  header('location: index.php');
}

if (isset($_GET['email']) && isset($_GET['token'])) {
  $email = $_GET['email'];
  $token = $_GET['token'];

  $query = mysqli_query($conn, "SELECT * FROM pembeli WHERE email_pembeli = '$email' AND token_ganti_pass = '$token'");
  $cek = mysqli_num_rows($query);

  if ($cek == 0) {
    echo "
			<script>
			alert('Link tidak valid. Email dan token tidak sesuai !');
			window.location.href = 'login.php';
			</script>
			";
  }

} else {
  header('location: login.php');
}

if (isset($_POST['ubahpass'])) {
  $email = $_GET['email'];
  $token = $_GET['token'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  $pesan_error = "";

  if ($password !== $password2) {
    $pesan_error .= "Retype password tidak sesuai ! <br>";
  }

  $aturan_pass1 = preg_match('@[A-Z]@', $password);
  $aturan_pass2 = preg_match('@[a-z]@', $password);
  $aturan_pass3 = preg_match('@[0-9]@', $password);

  if (!$aturan_pass1 || !$aturan_pass2 || !$aturan_pass3 || strlen($password) < 8) {
    $pesan_error .= "Password setidaknya harus 8 karakter dan harus memiliki huruf besar, huruf kecil, angka";
  }

  if ($pesan_error == "") {
    $password_baru = password_hash($password, PASSWORD_DEFAULT);
    $ubahpass = mysqli_query($conn, "UPDATE `pembeli` SET `password_pembeli` = '$password_baru', `token_ganti_pass` = NULL WHERE `email_pembeli` = '$email'");
    if ($ubahpass) {
      echo "
			<script>
			alert('Ubah Password Berhasil, Silahkan Login');
			window.location.href = 'login.php';
			</script>
			";
		} else {
			echo "
			<script>
			alert('Ubah Password Gagal !');
			window.location.href = 'ubahpassword.php?email=$email.com&token=$token.php';
			</script>
			";
    }
  }

} else {
  $pesan_error = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ubah Password Pengunjung</title>
  
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
            <div class="col-lg-5 col-md-8 align-item-center">
                <div class="border">
                    <h3 class="bg-gray p-4">Ubah Password Pengunjung</h3>
                    <form method="POST">
                      <fieldset class="p-4">

                      <?php if($pesan_error !== "") : ?>
                        <div class="alert alert-danger">
                          <?= $pesan_error; ?>
                        </div>
                      <?php endif; ?>

                      <div class="form-group">
                      <input type="password" placeholder="Password Baru" class="border p-3 w-100 my-2" name="password" required>
                      <input type="password" placeholder="Retype Password" class="border p-3 w-100 my-2" name="password2" required>
                            <button type="submit" class="d-block py-3 px-5 bg-primary text-white border-0 rounded font-weight-bold mt-3" name="ubahpass">Ubah Password</button>

                            <a class="mt-3 d-block text-primary" href="login.php">Kembali</a>
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

</html>