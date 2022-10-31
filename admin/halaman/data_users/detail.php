<?php 

include '../../../function.php';

$id = $_POST['id'];
$row = query("SELECT * FROM users WHERE `user_id` = '$id'")[0];

$user_id = $row['user_id'];
$username = $row['username'];
$nama_lengkap = $row['nama_lengkap'];
$telp_user = $row['telp_user'];
$jk_user = $row['jk_user'];
$alamat_user = $row['alamat_user'];
$foto_user = $row['foto_user'];
$email_user = $row['email_user'];

?>

<div class="modal fade" id="modaldetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail User</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </div>
      <form method="post" enctype="multipart/form-data" id="form-edit">
        <div class="modal-body">

        <h6 class="modal-title">Foto user</h6>
        <div class="row">
        <div class="col-md-4">
          <img src="../assets/img/<?= $foto_user; ?>" class="img-thumbnail" style="width: 250px;">
        </div>
          <ul>
            <li><b>Username : </b><?= $username; ?></li>
            <li><b>Nama Lengkap : </b><?= $nama_lengkap; ?></li>
            <li><b>No. Telp : </b><?= $telp_user; ?></li>
            <li><b>E-mail : </b><?= $email_user; ?></li>
            <li><b>Jenis Kelamin : </b><?= $jk_user; ?></li>
            <li><b>Alamat : </b><?= $alamat_user; ?></li>
          </ul>
        <div class="col-md-8">
            
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


