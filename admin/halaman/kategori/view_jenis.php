<div class="container-fluid">
  <!-- Page Heading -->
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Data Kategori</h4>
    </div>
    <div class="card-header py-3" style="background-color: #fff;">
      <button type="button" class="btn btn-primary tomboltambah" data-toggle="modal" data-target="#modaltambah"><i class="fas fa-plus"></i> Tambah Kategori</button>

      <a href="?halaman=kategori&aksi=datatable" class="btn btn-success"><i class="fas fa-table"></i> Data Table</a>
    </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Kategori Produk</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No.</th>
                <th>Kategori Produk</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody id="viewdata">
            <?php 

            $i = 1;
            $result = query("SELECT * FROM jenis ORDER BY `id_jenis` DESC");
            foreach ($result as $data) :

            ?>
              <tr>
                  <td><?= $i; ?>.</td>
                  <td><?= $data['jenis']; ?></td>
                  <td>
                    <button type="button" class="btn btn-warning btn-circle" onclick="tampiledit('<?= $data['id_jenis']; ?>')">
                      <i class="fas fa-tags"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-circle" onclick="hapus('<?= $data['id_jenis']; ?>', '<?= $data['jenis']; ?>')">
                      <i class="fas fa-trash"></i>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </div>
      <form method="post" id="form-tambah">
        <div class="modal-body">

        <div class="row">
          <div class="col-md-12">
            <div class="mb-3">
                <label for="jenis" class="form-label">Kategori Produk</label>
                <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Masukkan jenis..." value="" required>
                <div class="invalid-feedback errorJenis">
                    
                </div>
            </div>
            
          </div>
      </div>
      </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btntambah">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->

<div class="viewmodal" style="display: none;"></div>

<script>

    // tambah data
    $("#form-tambah").submit(function(e){
		e.preventDefault();
		$.ajax({
			type:  $(this).attr("method"),
			url: "halaman/kategori/proses.php?aksi=tambah",
      dataType: "json",
			data: $(this).serialize(),
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
            if (response.error.jenis) {
              $('#jenis').addClass('is-invalid');
              $('.errorJenis').html(response.error.jenis);
            } else {
              $('#jenis').removeClass('is-invalid');
              $('.errorJenis').html('');
            }
          
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: response.sukses
            });
            $('#jenis').removeClass('is-invalid');
            $('.errorJenis').html('');

            $("#viewdata").empty();
            $("#viewdata").html(response.data);
            $("#modaltambah").modal('hide');
            $('#jenis').val('');
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

  // tampil modal edit
  function tampiledit(id) {
    $.ajax({
      type: 'POST',
      url: "halaman/kategori/modaledit.php",
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
  function hapus(id, jenis) {
    Swal.fire({
    title: 'Hapus',
    text: `Yakin menghapus kategori ${jenis} ?`,
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
          url: "halaman/kategori/proses.php?aksi=hapus",
          data: {
            id:id,
            jenis: jenis
          },
          dataType: "json",
          success: function (response){
            // console.log(response.data);
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

</script>