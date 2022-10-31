<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Data Users</h4>
    </div>
    <div class="card-header py-3" style="background-color: #fff;">
      <button type="button" class="btn btn-primary tomboltambah" data-toggle="modal" data-target="#modaltambah"><i class="fas fa-plus"></i> Tambah User</button>

      <a href="?halaman=data_users" class="btn btn-success"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Foto</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No.</th>
                <th>Foto</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody id="viewdata">
            <?php 

            $i = 1;
            $result = query("SELECT * FROM users ORDER BY `user_id` DESC");
            foreach ($result as $data) :

            ?>
              <tr>
                  <td><?= $i; ?>.</td>
                  <td><a href="../assets/img/<?= $data['foto_user']; ?>" class="perbesar"><img src="../assets/img/<?= $data['foto_user']; ?>" style="width: 100px;"></a></td>
                  <td><?= $data['username']; ?></td>
                  <td><?= $data['nama_lengkap']; ?></td>
                  <td><?= $data['jk_user']; ?></td>
                  <td>
                    <button type="button" class="btn btn-warning btn-circle" onclick="tampiledit('<?= $data['user_id']; ?>')">
                      <i class="fas fa-tags"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-circle" onclick="hapus('<?= $data['user_id']; ?>', '<?= $data['username']; ?>')">
                      <i class="fas fa-trash"></i>
                    </button>

                    <button type="button" class="btn btn-success btn-circle" onclick="detail('<?= $data['user_id']; ?>')">
                      <i class="fas fa-eye"></i>
                    </button>
                  </td>
              </tr>
            <?php
            $i++;
            endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>

<!-- modal tambah -->
<div class="modal fade" id="modaltambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </div>
      <form method="post" enctype="multipart/form-data" id="form-tambah">
        <div class="modal-body">

          <div class="row">
          <div class="col-6">

            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username..." required autofocus>
                <div class="invalid-feedback errorUsername">
                    
                </div>
            </div>

            <div class="mb-3">
              <label for="passowrd" class="form-label">Password</label>
              <div class="form-group row">
              <div class="col-sm-6">
                  <input type="password" class="form-control form-control-user" id="password" placeholder="Password..." name = "password" value="" required>
                  <div class="invalid-feedback errorAturan">
                    
                  </div>                        
                </div>
                
                <div class="col-sm-6">
                  <input type="password" class="form-control form-control-user" id="password2" placeholder="Repeat Password..." name="password2" value="" required>
                  <div class="invalid-feedback errorPassword">
                    
                  </div>
              </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap..." required>
            </div>
            
            <div class="mb-3">
              <label for="jk_user" class="form-label">Jenis Kelamin</label>
                <select name="jk_user" class="form-control" id="jk_user">
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
              <label for="telp_user" class="form-label">No. Telp</label>
                <input type="number" class="form-control" id="telp_user" name="telp_user" placeholder="Masukkan No. telp..." required>
            </div>
          </div>
          
          <div class="col-6">

            <div class="mb-3">
              <label for="email_user" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email_user" name="email_user" placeholder="Masukkan E-mail..." required>
                <div class="invalid-feedback errorEmail">
                    
                </div>  
            </div>

            <div class="mb-3">
              <label for="alamat_user" class="form-label">Alamat</label>
                <textarea name="alamat_user" id="alamat_user" rows="3" class="form-control" placeholder="Masukkan alamat..." required></textarea>
            </div>

            <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <br>
              <img src="../assets/img/default.svg" class="img-thumbnail img-preview mb-3" id="preview" style="height: 150px;">
                  <input class="form-control" type="file" id="foto" name="foto" onchange="previewFoto()">
                  <div class="invalid-feedback errorFoto">
                  
                  </div>
            </div>
          </div>

        </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btntambah">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>

// function data(){
//     $.ajax({
//       url: "halaman/data_users/datausers.php",
//       success: function (response){
//         // diambil dari nilai json menggunakan .data
//         $('#viewdata').html(response);
//       },
//       // melihat error
//       error: function(xhr, ajaxOptions, thrownError){
//         alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
//       }
//     });
//   }

  // tampil detail
  function detail(id) {
    $.ajax({
      type: 'POST',
      url: 'halaman/data_users/detail.php',
      data: {
        id: id
      },
      success: function (response) {
        console.log(response);
        $('.viewmodal').html(response).show();
        $('#modaldetail').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError){
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  // tampil modal edit
  function tampiledit(id) {
    $.ajax({
      type: 'POST',
      url: "halaman/data_users/modaledit.php",
      data: {
        id: id
      },
      success: function (response) {
        console.log(response);
        $('.viewmodal').html(response).show();
        $('#modaledit').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError){
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

  // hapus data
  function hapus(id, username) {
    Swal.fire({
    title: 'Hapus',
    text: `Yakin menghapus data user dengan username ${username} ?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'tidak',
  }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "halaman/data_users/proses.php?aksi=hapus",
          data: {
            id:id,
            username: username
          },
          dataType: "json",
          success: function (response){
            if (response.sukses) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.sukses,
              });
            $("#viewdata").empty();
            $("#viewdata").html(response.data);
            }
          },
            error: function(xhr, ajaxOptions, thrownError){
              alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
  });
  }
  
  // tambah data
  $("#form-tambah").on('submit', function(e){
		e.preventDefault();
    var form = $('#form-tambah')[0];
    var data = new FormData(form);

		$.ajax({
			method:  $(this).attr("method"), 
			url: "halaman/data_users/proses.php?aksi=tambah",
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",
			data: data,
      beforeSend:function() {
        $('.btntambah').attr('disable', 'disabled');
        $('.btntambah').html('<i class="fa fa-spin fa-spinner"></i>');
      },
      complete:function(){
        $('.btntambah').removeAttr('disable');
        $('.btntambah').html('Tambah');
      },
			success:function(response){
        console.log(response);
          if (response.error) {
            if (response.error.username) {
              $('#username').addClass('is-invalid');
              $('.errorUsername').html(response.error.username);
            } else {
              $('#username').removeClass('is-invalid');
              $('.errorUsername').html('');
            }

            if (response.error.password) {
              $('#password2').addClass('is-invalid');
              $('.errorPassword').html(response.error.password);
            } else {
              $('#password2').removeClass('is-invalid');
              $('.errorPassword').html('');
            }

            if (response.error.aturan_error) {
              $('#password').addClass('is-invalid');
              $('.errorAturan').html(response.error.aturan_error);
            } else {
              $('#password').removeClass('is-invalid');
              $('.errorAturan').html('');
            }

            if (response.error.email) {
              $('#email_user').addClass('is-invalid');
              $('.errorEmail').html(response.error.email);
            } else {
              $('#email_user').removeClass('is-invalid');
              $('.errorEmail').html('');
            }

            if (response.error.foto) {
              $('#foto').addClass('is-invalid');
              $('.errorFoto').html(response.error.foto);
            } else {
              $('#foto').removeClass('is-invalid');
              $('.errorFoto').html('');
            }
          
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.sukses
            });
            $('#username').removeClass('is-invalid');
            $('.errorUsername').html('');
            $('#password2').removeClass('is-invalid');
            $('.errorPassword').html('');
            $('#password').removeClass('is-invalid');
            $('.errorPassword2').html('');
            $('input[name=email]').removeClass('is-invalid');
            $('.errorEmail').html('');
            $('#foto').removeClass('is-invalid');
            $('.errorFoto').html('');

            // mengosongkan form
            $("#viewdata").empty();
            $("#viewdata").html(response.data);
            $("#modaltambah").modal('hide');
            $('#username').val('');
            $('#password').val('');
            $('#password2').val('');
            $('#telp_user').val('');
            $('#nama_lengkap').val('');
            $('#alamat_user').val('');
            $('#foto').val('');
            $('#email_user').val('');

            // menormalkan preview img
            $("#preview").removeAttr('src');
            $("#preview").attr('src', '../assets/img/default.svg');
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