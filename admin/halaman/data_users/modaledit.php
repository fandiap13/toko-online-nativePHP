<?php 

include '../../../function.php';

$id = $_POST['id'];
$row = query("SELECT * FROM users WHERE `user_id` = '$id'")[0];

$user_id = $row['user_id'];
$username = $row['username'];
$password = $row['password'];
$nama_lengkap = $row['nama_lengkap'];
$telp_user = $row['telp_user'];
$jk_user = $row['jk_user'];
$alamat_user = $row['alamat_user'];
$foto_user = $row['foto_user'];
$email_user = $row['email_user'];

?>

<!-- <script src="../assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    $(document).ready(function(){
      tinymce.init({
      selector: "#alamat_user_edit",
      setup: function (editor) {
          editor.on('change', function () {
              editor.save();
          });
        }
      });
    })
</script> -->

<div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </div>
      <form method="post" enctype="multipart/form-data" id="form-edit">
        <div class="modal-body">

        <div class="row">
          <div class="col-md-6">
          <input type="hidden" name="user_id" id="user_id_edit" value="<?= $user_id; ?>">
          <input type="hidden" name="foto_lama" id="foto_lama_edit" value="<?= $foto_user; ?>">

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username_edit" name="username" placeholder="Masukkan username..." value="<?= $username; ?>" required>
                <div class="invalid-feedback errorUsernameEdit">
                    
                </div>
            </div>

            <div class="mb-3">
            <label for="passowrd" class="form-label">Password</label>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <input type="password" class="form-control form-control-user" id="password_edit" placeholder="Password..." name="password" value="">
                <div class="invalid-feedback errorAturanEdit">
                  
                </div>                      
              </div>
              <div class="col-sm-6">
                <input type="password" class="form-control form-control-user" id="password2_edit" placeholder="Repeat Password..." name="password2" value="">
                <div class="invalid-feedback errorPasswordEdit">
                  
                </div>
              </div>
            </div>
            </div>

            <div class="mb-3">
              <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap_edit" name="nama_lengkap" placeholder="Masukkan nama lengkap..." value="<?= $nama_lengkap; ?>" required>
            </div>
            
            <div class="mb-3">
              <label for="jk_user" class="form-label">Jenis Kelamin</label>
              <select name="jk_user" class="form-control" id="jk_user_edit">
                <option value="Laki-laki" <?php if($jk_user == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                <option value="Perempuan" <?php if($jk_user == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="telp_user" class="form-label">No. Telp</label>
                <input type="number" class="form-control" id="telp_user_edit" name="telp_user" placeholder="Masukkan No. telp..." value="<?= $telp_user; ?>" required>
            </div>
          </div>
          
          <div class="col-md-6">
          <div class="mb-3">
            <label for="email_user" class="form-label">E-mail</label>
              <input type="email" class="form-control" id="email_user_edit" name="email_user" placeholder="Masukkan E-mail..." value="<?= $email_user; ?>" required>
              <div class="invalid-feedback errorEmailEdit">
                  
              </div>
          </div>
          
            <div class="mb-3">
              <label for="alamat_user" class="form-label">Alamat</label>
                <textarea name="alamat_user" id="alamat_user_edit" rows="3" class="form-control" placeholder="Masukkan alamat..." required><?= $alamat_user; ?></textarea>
            </div>

            <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <br>
                <img src="../assets/img/<?= $foto_user; ?>" class="img-thumbnail img-preview2 mb-3" id="preview" style="height: 150px;">
                  <input class="form-control fotoEdit" type="file" id="foto2" name="foto" onchange="previewFoto2()">
                  <div class="invalid-feedback errorFotoEdit">
                  
                  </div>
            </div>
          </div>
          
      </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btnedit">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // edit data
  $("#form-edit").on('submit', function(e){
		e.preventDefault();
    var form = $('#form-edit')[0];
    var data = new FormData(form);

		$.ajax({
			method:  $(this).attr("method"), 
			url: "halaman/data_users/proses.php?aksi=edit",
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",
			data: data,
      beforeSend:function() {
        $('.btnedit').attr('disable', 'disabled');
        $('.btnedit').html('<i class="fa fa-spin fa-spinner"></i>');
      },
      complete:function(){
        $('.btnedit').removeAttr('disable');
        $('.btnedit').html('simpan');
      },
			success:function(response){
        console.log(response);
          if (response.error) {
            if (response.error.username) {
              $('#username_edit').addClass('is-invalid');
              $('.errorUsernameEdit').html(response.error.username);
            } else {
              $('#username_edit').removeClass('is-invalid');
              $('.errorUsernameEdit').html('');
            }

            if (response.error.password) {
              $('#password2_edit').addClass('is-invalid');
              $('.errorPasswordEdit').html(response.error.password);
            } else {
              $('#password2_edit').removeClass('is-invalid');
              $('.errorPassword').html('');
            }

            if (response.error.foto) {
              $('.fotoEdit').addClass('is-invalid');
              $('.errorFotoEdit').html(response.error.foto);
            } else {
              $('.fotoEdit').removeClass('is-invalid');
              $('.errorFotoEdit').html('');
            }

            if (response.error.aturan) {
              $('#password_edit').addClass('is-invalid');
              $('.errorAturanEdit').html(response.error.aturan);
            } else {
              $('#password_edit').removeClass('is-invalid');
              $('.errorAturanEdit').html('');
            }

            if (response.error.email) {
              $('#email_user_edit').addClass('is-invalid');
              $('.errorEmailEdit').html(response.error.email);
            } else {
              $('#email_user_edit').removeClass('is-invalid');
              $('.errorEmailEdit').html('');
            }
          
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.sukses
            });

            $("#viewdata").empty();
            $("#viewdata").html(response.data);
            $("#modaledit").modal('hide');
        }
			},
			error: function(xhr, ajaxOptions, thrownError)
      {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
		})
		.done(function(d) {
			// When ajax finished
		});
	});
</script>


