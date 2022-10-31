<?php 

include '../../../function.php';

$id = $_POST['id'];
$row = query("SELECT * FROM pembeli WHERE `id_pembeli` = '$id'")[0];

$username_pembeli = $row['username_pembeli'];
$nama_pembeli = $row['nama_pembeli'];
$telp_pembeli = $row['telp_pembeli'];
$jk_pembeli = $row['jk_pembeli'];
$alamat_pembeli = $row['alamat_pembeli'];
$foto_pembeli = $row['foto_pembeli'];
$email_pembeli = $row['email_pembeli'];

?>

<div class="modal fade" id="modaldetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Pembeli</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </div>
      <form method="post" enctype="multipart/form-data" id="form-edit">
        <div class="modal-body">

        <h6 class="modal-title">Foto Pembeli</h6>
        <div class="row">
        <div class="col-md-4">
          <img src="../assets/img/<?= $foto_pembeli; ?>" class="img-thumbnail" style="width: 250px;">
        </div>
        <div class="col-md-8">
          <ul>
            <li><b>Username : </b><?= $username_pembeli; ?></li>
            <li><b>Nama Lengkap : </b><?= $nama_pembeli; ?></li>
            <li><b>No. Telp / WA : </b><?= $telp_pembeli; ?></li>
            <li><b>E-mail : </b><?= $email_pembeli; ?></li>
            <li><b>Jenis Kelamin : </b><?= $jk_pembeli; ?></li>
            <li><b>Alamat : </b><?= $alamat_pembeli; ?></li>
          </ul>
        </div>
          
      </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


