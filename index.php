<?php

$nm_hal = 'index'; 
$title = 'Beranda';

include "template/header.php"; 

?>

<style>
	.bg-1 {
    background: url('assets/img/bg.jpeg');
    background-size: cover;
    background-repeat: no-repeat;
}
</style>

<section class="hero-area bg-1 text-center overly">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Header Contetnt -->
				<div class="content-block">
					<h1>Kerupuk Kulit Sapi Kendil </h1>
					<p><?= $toko['alamat']; ?></p>
					
				</div>
				<!-- Advance Search -->
				<div class="advance-search">
						<div class="container">
							<div class="row justify-content-center">
								<div class="col-lg-12 col-md-12 align-content-center">
										<form action="daftarproduk.php" method="POST">
											<div class="form-row">
												<div class="form-group col-md-6">
													<input type="text" class="form-control my-2 my-lg-1" id="inputtext4" placeholder="Nama Produk" name="nama_produk" required>
												</div>
												<div class="form-group col-md-4">
													<select class="w-100 form-control mt-lg-1 mt-md-2" name="jenis">
														<option value="0">--Kategori--</option>
														<?php 
														
														$datakategori = query("SELECT * FROM jenis");
														foreach ($datakategori as $k) :
														?>
														<option value="<?= $k['id_jenis']; ?>"><?= $k['jenis']; ?></option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group col-md-2 align-self-center">
													<button type="submit" class="btn btn-primary" name="cari">Cari</button>
												</div>
											</div>
										</form>
									</div>
								</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>

<section class="popular-deals section bg-gray">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="section-title">
					<h2>Produk Terbaru</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<!-- offer 01 -->
			<div class="col-lg-12">
				<div class="trending-ads-slide">
						<!-- product card -->
						<?php 
            
						$dataproduk = query("SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis ORDER BY tgl_post DESC");
            foreach ($dataproduk as $p) :
            ?>
						<div class="col-sm-12 col-lg-4 col-md-6">
							<!-- product card -->
							<!-- <div class="card" style="width: 18rem;">
							<img src="..." class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title">Card title</h5>
								<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
								<a href="#" class="btn btn-primary">Go somewhere</a>
							</div>
						</div> -->

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

											<!-- mengatur link -->
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
			
			
		</div>
	</div>
</section>



<!--==========================================
=            All Category Section            =
===========================================-->

<section class=" section">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-12">
				<!-- Section title -->
				<div class="section-title">
					<h2>Semua Kategori</h2>
				</div>
				<div class="row">
					<!-- Category list -->
					<?php

					$datakategori = query("SELECT * FROM jenis");
					foreach ($datakategori as $k) :
					
					?>
					<div class="col-lg-3 offset-lg-0 col-md-5 offset-md-1 col-sm-6 col-6">
						<div class="category-block">
							<a href="kategoriproduk.php?kategori=<?= $k['jenis']; ?>"><h4 align="center"><?= $k['jenis']; ?></h4></a>
						</div>
					</div>
					<?php endforeach; ?>
					<!-- /Category List -->
				</div>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>

<?php include "template/footer.php"; ?>

<?php if(isset($_SESSION['alert'])) { ?>
    <?php if($_SESSION['alert'] == true) { ?>
      <script>
          const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 5000
          });

          setTimeout(function() {
            Toast.fire({
              icon: 'success',
              title: "Selamat datang, <?= $_SESSION['username']; ?>",
          });
          },500);
      </script>
    <?php } ?>
  <?php unset($_SESSION['alert']); ?>
<?php } ?>