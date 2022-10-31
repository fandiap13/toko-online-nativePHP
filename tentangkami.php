<?php

$nm_hal = 'tentangkami'; 
$title = 'Tentang Kami';

include "template/header.php"; 

?>

<section class="page-title">
	<!-- Container Start -->
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2 text-center">
				<!-- Title text -->
				<h3>Tentang Kami</h3>
			</div>
		</div>
	</div>
	<!-- Container End -->
</section>

<section class="section">
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-4">
                <div class="about-img">
                  <a href="assets/img/toko/<?= $toko['foto']; ?>" class="perbesar">
                    <img src="assets/img/toko/<?= $toko['foto']; ?>" class="img-fluid w-100 rounded" alt="">
                  </a>
                </div>
            </div>
            <div class="col-lg-8 pt-5 pt-lg-0">
                <div class="about-content">
                    <h3 class="font-weight-bold">Pengenalan</h3>
                    <?= $toko['tentang_kami']; ?>

                    <div class="row">
                      <div class="col-md-4">
                        <h4>Alamat Toko</h4>
                        <p><?= $toko['alamat']; ?></p>
                      </div>
                      <div class="col-md-4">
                        <h4>No. Telp / WA</h4>
                        <p> +<?= $toko['telp']; ?></p>
                      </div>
                      <div class="col-md-4">
                        <h4>E-mail</h4>
                        <p><?= $toko['email']; ?></p>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <h4>Lokasi Toko</h4>
              <iframe src="//www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1977.0664207962354!2d111.07577017511797!3d-7.668864513444212!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbebb56f6b672cc47!2sMasjid%20zainab%20Ummu%20Salamah!5e0!3m2!1sid!2sid!4v1638793374996!5m2!1sid!2sid" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>

<?php include "template/footer.php"; ?>