<?php 

include "function.php";

if (isset($_SESSION['login'])) {
	if ($_SESSION['login'] == 'pembeli') {
		// tampil data pembeli
		$sespembeli = $_SESSION['id_pembeli'];
		$pembeli = query("SELECT * FROM pembeli WHERE id_pembeli = $sespembeli")[0];
	}
}

$toko = query("SELECT * FROM toko")[0];

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?></title>
  
  <!-- FAVICON -->
  <link href="assets/img/favicon.png" rel="shortcut icon">
  <!-- PLUGINS CSS STYLE -->
  <!-- <link href="assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet"> -->
  <!-- Bootstrap -->
	<!-- <link href="assets/css/sb-admin-2.min.css" rel="stylesheet"> -->

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

	<!-- Custom styles for this page -->
  <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" /> -->


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!-- [if lt IE 9]> -->
  <!-- <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> -->
  <!-- <![endif] -->

	
	<link rel="stylesheet" href="assets/sweeetalert2/dist/sweetalert2.min.css">
  <script src="assets/sweeetalert2/dist/sweetalert2.all.min.js"></script>
	
	<!-- select2 -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

	<link rel="stylesheet" href="assets/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

</head>

<body class="body-wrapper">

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<nav class="navbar navbar-expand-lg navbar-light navigation">
					<a class="navbar-brand" href="index.php">
						<img src="assets/img/logo.png" width="200px">
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav ml-auto main-nav ">
							
							<li class="nav-item <?= ($nm_hal == 'index') ? 'active' : ''; ?>">
								<a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a>
							</li>

							<li class="nav-item <?= ($nm_hal == 'daftarproduk') ? 'active' : ''; ?>">
								<a class="nav-link" href="daftarproduk.php"><i class="fa fa-product-hunt"></i> Produk</a>
							</li>

							<li class="nav-item <?= ($nm_hal == 'tentangkami') ? 'active' : ''; ?>">
								<a class="nav-link" href="tentangkami.php"><i class="fa fa-info"></i> Tentang Kami</a>
							</li>

							<li class="nav-item <?= ($nm_hal == 'kontakkami') ? 'active' : ''; ?>">
								<a class="nav-link" href="kontakkami.php"><i class="fa fa-id-badge"></i> Kontak Kami</a>
							</li>

							<?php if (isset($_SESSION['login'])) : ?>
								<?php if ($_SESSION['login'] == 'pembeli') { ?>
									<li class="nav-item <?= ($nm_hal == 'keranjang') ? 'active' : ''; ?>">
										<a class="nav-link" href="keranjang.php"><i class="fa fa-shopping-cart"></i> Keranjang</a>
									</li>

									<li class="nav-item <?= ($nm_hal == 'transaksi') ? 'active' : ''; ?>">
										<a class="nav-link" href="transaksi.php"><i class="fa fa-money"></i> Transaksi</a>
									</li>

									<!-- Nav Item - User Information -->
									<li class="nav-item dropdown no-arrow">
										<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
												data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<img class="img-profile rounded-circle"
														src="assets/img/<?= $pembeli['foto_pembeli']; ?>" style="width: 50px; height:50px;">
										</a>
										<!-- Dropdown - User Information -->
										<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
												aria-labelledby="userDropdown">
												<a class="dropdown-item" href="profile.php">
														<i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
														Profile
												</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
														<i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>
														Logout
												</a>
												</div>
										</li>
								<?php } ?>
							<?php endif; ?>

						</ul>
						<?php if (!isset($_SESSION['login'])) { ?>
							<ul class="navbar-nav ml-auto mt-10">
								<li class="nav-item">
									<a class="nav-link login-button" href="login.php">Login</a>
								</li>
							</ul>
						<?php } ?>
					</div>
				</nav>
			</div>
		</div>
	</div>
</section>