<?php 

$title = 'Detail Produk';
include "template/header.php";

$id_produk = $_GET['id'];
$dataproduk = query("SELECT * FROM produk INNER JOIN jenis ON jenis.id_jenis = produk.id_jenis WHERE produk.id_produk = '$id_produk'")[0];

// foto_produk
$datafoto = [];
$queryfoto = mysqli_query($conn, "SELECT * FROM foto_produk WHERE id_produk = '$id_produk'");
while($row = mysqli_fetch_assoc($queryfoto)){
	$datafoto[] = $row;
}

$jmlfoto = mysqli_num_rows($queryfoto);

?>

<section class="section bg-gray">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<!-- Left sidebar -->
			<div class="col-md-8">
				<div class="product-details">
					<h1 class="product-title"><?= $dataproduk['nama_produk']; ?></h1>
					<div class="product-meta">
						<ul class="list-inline">
							<li class="list-inline-item"><i class="fa fa-folder-open-o"></i> Kategori<a href="kategoriproduk.php?kategori=<?= $dataproduk['jenis']; ?>"><?= $dataproduk['jenis']; ?></a></li>
						</ul>
					</div>

					<!-- product slider -->
					<?php if($jmlfoto > 1) { ?>
					<div class="product-slider">
					<?php } ?>
			
					<?php foreach($datafoto as $foto) : ?>
						<div class="product-slider-item my-4" data-image="assets/img/produk/<?= $foto['nama_foto_produk']; ?>">
							<img class="img-fluid w-100" src="assets/img/produk/<?= $foto['nama_foto_produk']; ?>" alt='Second slide'>
						</div>
					<?php endforeach; ?>

					<?php if($jmlfoto > 1) { ?>
					</div>
					<?php } ?>
					<!-- product slider -->

					<div class="content mt-5 pt-5">
						<ul class="nav nav-pills  justify-content-center" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home"
								 aria-selected="true">Deskripsi Produk</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact"
								 aria-selected="false">Reviews</a>
							</li>
						</ul>
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <h3 class="tab-title">Deskripsi Produk</h3>
								<table class="table table-bordered product-table">
									<tbody>
                  <tr>
											<td>Tanggal Posting</td>
											<td><?= date("d F Y, H:i", strtotime($dataproduk['tgl_post'])); ?></td>
										</tr>
										<tr>
											<td>Kategori</td>
											<td><a href="kategoriproduk.php?kategori=<?= $dataproduk['jenis']; ?>"><?= $dataproduk['jenis']; ?></a></td>
										</tr>
										<tr>
											<td>Berat</td>
											<td><?= number_format($dataproduk['berat_produk']); ?> Gram</td>
										</tr>
										<tr>
											<td>Harga</td>
											<td>Rp. <?= number_format($dataproduk['harga_produk']); ?></td>
										</tr>
										<tr>
											<td>Status Produk</td>
											<td><nav class="badge <?= ($dataproduk['status_produk'] == 'Tidak tersedia') ? 'badge-danger' : 'badge-success'; ?>"><?= $dataproduk['status_produk']; ?></nav></td>
										</tr>
									</tbody>
								</table>
                
								<p><?= $dataproduk['deskripsi_produk']; ?></p>
							</div>

							<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
								<h3 class="tab-title">Product Review</h3>
								<div class="product-review">
									<div class="media">
										<!-- Avater -->
										<img src="assets/images/user/user-thumb.jpg" alt="avater">
										<div class="media-body">
											<!-- Ratings -->
											<div class="ratings">
												<ul class="list-inline">
													<li class="list-inline-item">
														<i class="fa fa-star"></i>
													</li>
													<li class="list-inline-item">
														<i class="fa fa-star"></i>
													</li>
													<li class="list-inline-item">
														<i class="fa fa-star"></i>
													</li>
													<li class="list-inline-item">
														<i class="fa fa-star"></i>
													</li>
													<li class="list-inline-item">
														<i class="fa fa-star"></i>
													</li>
												</ul>
											</div>
											<div class="name">
												<h5>Jessica Brown</h5>
											</div>
											<div class="date">
												<p>Mar 20, 2018</p>
											</div>
											<div class="review-comment">
												<p>
													Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremqe laudant tota rem ape
													riamipsa eaque.
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="sidebar">
					<div class="widget price text-center">
						<h4>Harga</h4>
						<p>Rp. <?= number_format($dataproduk['harga_produk']); ?></p>
					</div>
          <div class="widget text-center">

						<?php 
											
						if (isset($_SESSION['login'])) {
							if ($_SESSION['login'] == 'pembeli') {
								$linkbeli = "beli.php?id=".$dataproduk['id_produk'];
							} elseif ($_SESSION['login'] == 'user') {
								$linkbeli = "admin/index.php";
							}
						} elseif(!isset($_SESSION['login'])) {
							$linkbeli = "login.php?need-login=yes";
						}

						?>

            <a href="<?= $linkbeli; ?>" class="btn btn-primary <?= ($dataproduk['status_produk'] == 'Tidak tersedia') ? 'disabled' : ''; ?> mb-3"><i class="fa fa-shopping-cart"></i> Tambah Keranjang</a>
						<?php $pesan = "Apakah Produk *" .$dataproduk['nama_produk']. "* masih tersedia ?"; ?>
						<a href="https://wa.me/62895392518509?text=<?= $pesan; ?>" class="btn btn-success" target="_blank"><i class="fa fa-whatsapp"></i> Hubungi Penjual</a>
          </div>
				</div>
			</div>

		</div>
	</div>
	<!-- Container End -->
</section>

<?php include "template/footer.php"; ?>