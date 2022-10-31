<?php 

include '../../../function.php';

$id = $_POST['id'];
$row = query("SELECT * FROM jenis WHERE `id_jenis` = '$id'")[0];

$jenis = $row['jenis'];

?>

<div class="modal fade" id="modaledit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </div>
      <form method="post" id="form-edit">
        <div class="modal-body">

        <div class="row">
          <div class="col-md-12">
          <input type="hidden" name="id_jenis" id="id_jenis_edit" value="<?= $id; ?>">

            <div class="mb-3">
                <label for="jenis" class="form-label">Kategori Produk</label>
                <input type="text" class="form-control" id="jenis_edit" name="jenis" placeholder="Masukkan jenis..." value="<?= $jenis; ?>" required>
                <div class="invalid-feedback errorJenisEdit">
                    
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
		$.ajax({
			type:  $(this).attr("method"), 
			url: "halaman/kategori/proses.php?aksi=edit",
      dataType: "json",
			data: $(this).serialize(),
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
            if (response.error.jenis) {
              $('#jenis_edit').addClass('is-invalid');
              $('.errorJenisEdit').html(response.error.jenis);
            } else {
              $('#jenis_edit').removeClass('is-invalid');
              $('.errorJenisEdit').html('');
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


