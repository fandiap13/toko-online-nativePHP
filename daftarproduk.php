<?php

$nm_hal = 'daftarproduk';
$title = 'Daftar Produk';

include "template/header.php";

$urutkan = "";

// search
if (isset($_POST['cari'])) {
	$id_jenis = $_POST['jenis'];
	$nama_produk = $_POST['nama_produk'];
	$pesan_error = "";
	$pesan_berhasil = "";
	$tgl_sekarang = date('d M Y');

	if ($_POST['jenis'] !== "0") {
		$query = "SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis WHERE produk.id_jenis = '$id_jenis' AND produk.nama_produk LIKE '%$nama_produk%'";
		$query_produk = mysqli_query($conn, $query);

		$dataproduk = query($query);
		$jml_cari = mysqli_num_rows($query_produk);

		if ($jml_cari > 0) {
			$pesan_berhasil = "Ada $jml_cari Hasil Pada $tgl_sekarang";
		} elseif ($jml_cari == 0) {
			$pesan_error = "Tidak Ada !";
		}
		
	} elseif ($_POST['jenis'] == "0") {
		$query = "SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis WHERE produk.nama_produk LIKE '%$nama_produk%'";
		$query_produk = mysqli_query($conn, $query);

		$dataproduk = query($query);
		$jml_cari = mysqli_num_rows($query_produk);

		if ($jml_cari > 0) {
			$pesan_berhasil = "Ada $jml_cari Hasil Pada $tgl_sekarang";
		} elseif ($jml_cari == 0) {
			$pesan_error = "Tidak Ada !";
		}
	}

} else {
	$dataproduk = query("SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis");
	$id_jenis = "";
	$nama_produk = "";
	$pesan_error = "";
	$pesan_berhasil = "";
}

// mengurutkan
if (isset($_POST['cari2'])){
	$urutkan = $_POST['urutkan'];
	switch ($urutkan) {
		case 'terendah':
			$dataproduk = query("SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis ORDER BY produk.harga_produk ASC");
			break;

		case 'tertinggi':
			$dataproduk = query("SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis ORDER BY produk.harga_produk DESC");
			break;

		case 'terbaru':
			$dataproduk = query("SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis ORDER BY produk.id_produk DESC");
			break;

		case 'populer':
			// $dataproduk = query("SELECT *,sum(pembelian_produk.jml_pembelian) as banyak FROM produk LEFT JOIN pembelian_produk ON produk.id_produk = pembelian_produk.id_produk INNER JOIN jenis ON produk.id_jenis = jenis.id_jenis GROUP BY pembelian_produk.id_produk ORDER BY banyak DESC");
			$dataproduk = query("SELECT *,count(pembelian_produk.id_produk) as banyak FROM produk LEFT JOIN pembelian_produk ON produk.id_produk = pembelian_produk.id_produk INNER JOIN jenis ON produk.id_jenis = jenis.id_jenis GROUP BY pembelian_produk.id_produk ORDER BY banyak DESC");
			break;
	}
}


?>

<!-- search -->
<section class="page-search">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Advance Search -->
				<div class="advance-search">
					<form method="POST">
						<div class="form-row">
							<div class="form-group col-md-4">
								<input type="text" class="form-control my-2 my-lg-0" id="inputtext4" placeholder="Nama Produk" name="nama_produk" value="<?= $nama_produk; ?>" required>
							</div>
							<div class="form-group col-md-2">
								<select class="form-control my-2 my-lg-0" id="inputCategory4" name="jenis" required>
									<option value="0">--Kategori--</option>
									<?php 
									
									$datakategori = query("SELECT * FROM jenis");
									foreach ($datakategori as $k) :
									?>
									<option value="<?= $k['id_jenis']; ?>" <?= ($k['id_jenis'] == $id_jenis) ? 'selected' : ''; ?>><?= $k['jenis']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group col-md-2">
								<button type="submit" class="btn btn-secondary" name="cari">Cari</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="section-sm">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

			<?php if($pesan_berhasil !== "") { ?>
				<div class="search-result bg-gray">
					<h2>Hasil Untuk "<?= $nama_produk; ?>"</h2>
					<p><?= $pesan_berhasil; ?></p>
				</div>
			<?php } elseif($pesan_error !== "") {?>
				<div class="search-result bg-gray">
					<h2>Hasil Untuk "<?= $nama_produk; ?>"</h2>
					<p style="color: red;"><?= $pesan_error; ?></p>
				</div>
			<?php } ?>
			
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="category-sidebar">
					<div class="widget user-dashboard-menu">

					<!-- kategori -->
					<h4 class="widget-header">Semua Kategori</h4>
					<ul class="category-list">
						<?php 
						
						foreach ($datakategori as $k) :
						$jenis = $k['id_jenis'];
						// menghitung jumlah
						$query_jml = mysqli_query($conn, "SELECT * FROM produk WHERE id_jenis = $jenis");
						$jml = mysqli_num_rows($query_jml);

						?>
							<li><a href="kategoriproduk.php?kategori=<?= $k['jenis']; ?>"><?= $k['jenis']; ?> <span><?= $jml; ?></span></a></li>
						<?php endforeach; ?>
					</ul>
				</div>

<div class="widget filter">
	<h4 class="widget-header">Urutkan</h4>
	<form method="post">
		<select name="urutkan" class="form-control">
			<option value="terbaru" <?= ($urutkan == "terbaru") ? 'selected' : ''; ?>>Terbaru</option>
			<option value="populer" <?= ($urutkan == "populer") ? 'selected' : ''; ?>>Paling Populer</option>
			<option value="terendah" <?= ($urutkan == "terendah") ? 'selected' : ''; ?>>Harga Terendah</option>
			<option value="tertinggi" <?= ($urutkan == "tertinggi") ? 'selected' : ''; ?>>Harga Tertinggi</option>
		</select>
		<button type="submit" class="btn btn-main-sm mt-2" name="cari2">Cari</button>
	</form>
</div>

				</div>
			</div>
			<div class="col-md-9">
				<div class="category-search-filter">
					<div class="row">
						<div class="col-md-6">
							<strong>Urutkan</strong>
							<div class="row">

							<div class="col-md-6">
								<form method="post">
								<select name="urutkan" class="form-control">
									<option value="terbaru" <?= ($urutkan == "terbaru") ? 'selected' : ''; ?>>Terbaru</option>
									<option value="populer" <?= ($urutkan == "populer") ? 'selected' : ''; ?>>Paling Populer</option>
									<option value="terendah" <?= ($urutkan == "terendah") ? 'selected' : ''; ?>>Harga Terendah</option>
									<option value="tertinggi" <?= ($urutkan == "tertinggi") ? 'selected' : ''; ?>>Harga Tertinggi</option>
								</select>
							</div>
							<div class="col-md-6">
									<button type="submit" class="btn btn-main" style="display: block;" name="cari2">Cari</button>
								</form>
							</div>
							
							</div>
						</div>
					</div>
				</div>

				<div class="product-grid-list">
					<div class="row mt-30">
            <?php 
            
            foreach ($dataproduk as $p) :
            ?>
						<div class="col-sm-12 col-lg-4 col-md-6">
							<!-- product card -->

              <div class="product-item bg-light">
                <div class="card">
                  <div class="thumb-content">
                    <!-- <div class="price">$200</div> -->
                    <a href="detailproduk.php?id=<?= $p['id_produk']; ?>">
                      <img class="card-img-top img-fluid" src="assets/img/produk/<?= $p['foto_produk']; ?>" alt="Card image cap">
                    </a>
                  </div>
                  <div class="card-body">
                      <h4 class="card-title"><a href="detailproduk.php?id=<?= $p['id_produk']; ?>"><?= $p['nama_produk']; ?></a></h4>
                      <ul class="list-inline product-meta">
                        <li class="list-inline-item">
                          <a href="kategoriproduk.php?kategori=<?= $p['jenis']; ?>"><i class="fa fa-folder-open-o"></i><?= $p['jenis']; ?></a>
                        </li>
                      </ul>
											<p class="card-text"><b>Rp. <?= number_format($p['harga_produk']); ?></b></p>
											<p><nav class="badge <?= ($p['status_produk'] == 'Tidak tersedia') ? 'badge-danger' : 'badge-success'; ?>"><?= $p['status_produk']; ?></nav></p>
											<!-- <div class="product-ratings">
												<ul class="list-inline mb-3">
													<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
													<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
													<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
													<li class="list-inline-item selected"><i class="fa fa-star"></i></li>
													<li class="list-inline-item"><i class="fa fa-star"></i></li>
												</ul>
											</div> -->

											<?php 
											
											if (isset($_SESSION['login'])) {
												if ($_SESSION['login'] == 'pembeli') {
													$linkbeli = "beli.php?id=".$p['id_produk'];
												} elseif ($_SESSION['login'] == 'user') {
													$linkbeli = "admin/index.php";
												}
											} elseif(!isset($_SESSION['login'])) {
												$linkbeli = "login.php?need-login=yes";
											}

											?>

												<a href="<?= $linkbeli; ?>" class="btn btn-primary <?= ($p['status_produk'] == 'Tidak tersedia') ? 'disabled' : ''; ?>"><i class="fa fa-shopping-cart"></i></a>
												<?php $pesan = "Apakah Produk *" .$p['nama_produk']. "* masih tersedia ?"; ?>
												<a href="https://wa.me/62895392518509?text=<?= $pesan; ?>" class="btn btn-success" target="_blank"><i class="fa fa-whatsapp"></i></a>
										</div>
                </div>
              </div>
              
						</div>
            <?php endforeach; ?>
					</div>
				</div>

        <!-- pagination -->
				<!-- <div class="pagination justify-content-center">
					<nav aria-label="Page navigation example">
						<ul class="pagination">
							<li class="page-item">
								<a class="page-link" href="#" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
									<span class="sr-only">Previous</span>
								</a>
							</li>
							<li class="page-item"><a class="page-link" href="#">1</a></li>
							<li class="page-item active"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item">
								<a class="page-link" href="#" aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
									<span class="sr-only">Next</span>
								</a>
							</li>
						</ul>
					</nav>
				</div> -->
			</div>
		</div>
	</div>
</section>

<?php include "template/footer.php"; ?>