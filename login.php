<?php 

include "function.php";

if (isset($_SESSION['login'])) {
  header('location: index.php');
}


if (isset($_POST['login'])) {
  $username = htmlentities(strip_tags(trim($_POST['username'])));
  $password = htmlentities(strip_tags(trim($_POST['password'])));
  $pesan_gagal = "";

  // $username = "Fandi1234";
  // $pass = password_hash($username, PASSWORD_DEFAULT);
  // echo $pass;

  $loginpembeli = mysqli_query($conn, "SELECT * FROM pembeli WHERE username_pembeli = '$username' AND status_pendaftaran = 1");
  $cekpembeli = mysqli_num_rows($loginpembeli);

  if ($cekpembeli > 0) {
    $row = mysqli_fetch_assoc($loginpembeli);
    if (password_verify($password, $row['password_pembeli'])) {
      $_SESSION['id_pembeli'] = $row['id_pembeli'];
      $_SESSION['username'] = $username;
      $_SESSION['login'] = 'pembeli';
      $_SESSION['alert'] = true;
      
      header('location: index.php');
      exit;
    } else {
      $pesan_gagal = "Password salah";
    }
  } else {
    $pesan_gagal = "Username dan Password salah";
  }

} else {
  $pesan_gagal = "";
  $username = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Pengunjung</title>
  
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

  <link rel="stylesheet" href="assets/sweeetalert2/dist/sweetalert2.min.css">
  <script src="assets/sweeetalert2/dist/sweetalert2.all.min.js"></script>


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body class="body-wrapper">

<!-- <button type="button" onclick="Swal.fire('The Internet?','That thing is still around?','question')"></button> -->

<section class="login py-5 border-top-1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 align-item-center">
                <div class="border">
                    <h3 class="bg-gray p-4">Login Pengunjung</h3>
                    <form method="POST">
                      <fieldset class="p-4">
                          <?php if ($pesan_gagal !== "") : ?>
                            <div class="alert alert-danger" role="alert">
                              <?= $pesan_gagal; ?>
                            </div>
                          <?php endif; ?>

                            <input type="text" placeholder="Username" class="border p-3 w-100 my-2" name="username" value="<?= $username; ?>" required>
                            <input type="password" placeholder="Password" class="border p-3 w-100 my-2" name="password" required>
                            <div class="loggedin-forgot">
                            </div>
                            <button type="submit" class="d-block py-3 px-5 bg-primary text-white border-0 rounded font-weight-bold mt-3" name="login">Log in</button>
                            <a class="mt-3 d-block text-primary" href="index.php">Kembali ke beranda</a>
                            <a class="mt-3 d-block text-primary" href="lupapassword.php">Lupa Password?</a>
                            <a class="mt-3 d-inline-block text-primary" href="registrasi.php">Buat akun</a>
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

<?php if(isset($_GET['need-login'])) : ?>
  <?php if($username == "" || $password == "") : ?>
    <script>
    //   Swal.fire({
    //   position: 'top-end',
    //   icon: 'success',
    //   title: 'Your work has been saved',
    //   showConfirmButton: false,
    //   timer: 1500
    // })
      const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 5000
      });

      setTimeout(function() {
        Toast.fire({
          icon: 'warning',
          title: "Silahkan login dahulu sebelum membeli barang!",
      });
      },500);
    </script>
  <?php endif; ?>
<?php endif; ?>

</body>
</html>