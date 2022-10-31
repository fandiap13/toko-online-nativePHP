<?php 

include "function.php";


if (isset($_SESSION['login'])) {
  header('location: index.php');
}


if (isset($_POST['hapuspass'])) {
  $email_pembeli = $_POST['email_pembeli'];
  $pesan_error = "";
  $suksess = "";

  $query = mysqli_query($conn, "SELECT * FROM pembeli WHERE email_pembeli = '$email_pembeli' AND status_pendaftaran = 1");
  $tampil = mysqli_fetch_assoc($query);
  // $password = $tampil['password_pembeli'];
  
  $result = mysqli_num_rows($query);
	if ($result == 0) {
		$pesan_error = "Akun dengan E-mail <b>$email_pembeli</b> tidak terdaftar pada sistem.";
  } else {
    $token_ganti_pass = md5(rand(0,1000));
    $judul_email = "Ganti Password";
    $isi_email = "Seseorang meminta untuk melakukan perubahan password pada akun anda, silahkan klik link di bawah ini: <br>";
    $isi_email .= $lokasi."/ubahpassword.php?email=$email_pembeli&token=$token_ganti_pass";

    mysqli_query($conn, "UPDATE `pembeli` SET `token_ganti_pass` = '$token_ganti_pass' WHERE email_pembeli = '$email_pembeli'");

    $proses_berhasil = "Link ganti password sudah dikirim ke email <b>$email_pembeli</b>";

    $suksess = email($email_pembeli, $judul_email, $isi_email, $proses_berhasil);

  }

} else {
  $email_pembeli = "";
  $pesan_error = "";
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
  <title>Lupa Password</title>
  
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
                    <h3 class="bg-gray p-4">Lupa Password?</h3>
                    <form method="POST">
                      <fieldset class="p-4">

                      <?php if ($pesan_error !== "") : ?>
                        <div class="alert alert-danger">
                          <?= $pesan_error; ?>
                        </div>
                      <?php endif; ?>

                      <?php if ($suksess !== "") : ?>
                        <div class="alert alert-success">
                          <?= $suksess; ?>
                        </div>
                      <?php endif; ?>

                      <p>Masukkan email akun yang ingin dihapus passwordnya.</p>
                            <input type="email" placeholder="E-mail" class="border p-3 w-100 my-2" name="email_pembeli" value="<?= $email_pembeli; ?>" required>

                            <button type="submit" class="d-block py-3 px-5 bg-primary text-white border-0 rounded font-weight-bold mt-3" name="hapuspass">Kirim</button>

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