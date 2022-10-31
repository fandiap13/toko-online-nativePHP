<?php 

include '../../../function.php';

$id = $_POST['id'];
// $row = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli INNER JOIN pembayaran ON pembayaran.id_pembelian = pembelian.id_pembelian INNER JOIN bank ON bank.id_bank = pembayaran.id_bank WHERE pembelian.id_pembelian = '$id'")[0];
$row = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli INNER JOIN pembayaran ON pembayaran.id_pembelian = pembelian.id_pembelian WHERE pembelian.id_pembelian = '$id'")[0];

?>

<script>
    $(document).ready(function() {
      $('.perbesar').fancybox();
    });
</script>

<div class="modal fade" id="modalpembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <form id="form-pembayaran">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Data Pembayaran</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </div>
      <div class="modal-body">
        <h5 class="modal-title">Bukti Pembayaran</h5>

        <div class="row">
          <div class="col-md-4">
            <a href="../assets/img/bukti/<?= $row['bukti']; ?>" class="perbesar"><img src="../assets/img/bukti/<?= $row['bukti']; ?>" class="img-thumbnail" style="width: 250px;"></a>
          </div>
          <div class="col-md-8">
            <ul>
              <li><b>Nama Pembeli : </b><?= $row['nama_pembeli']; ?></li>
              <li><b>Bank : </b><?= $row['bank']; ?></li>
              <li><b>Jumlah Pembayaran : </b>Rp. <?= number_format($row['jumlah']); ?></li>
              <li><b>Tanggal Pembayaran : </b><?= date("d F Y, H:i", strtotime($row['tanggal'])); ?></li>
              <li><b>Status Pembelian : </b><?= $row['status_pembelian']; ?></li>
            </ul>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-6">

          <input type="hidden" name="id_pembelian" value="<?= $id; ?>" id="id_pembelian">
            <div class="mb-3">
                <label for="no_resi" class="form-label">No. Resi Pengiriman</label>
                <input type="text" class="form-control" id="no_resi" name="no_resi" placeholder="Masukkan No. Resi" value="<?= $row['no_resi']; ?>">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status_pembelian" class="form-control" id="status_pembelian">
                  <option value="6" <?= ($row['status_pembelian'] == 6 ? 'selected' : ''); ?>>Diproses Penjual</option>
                  <option value="2" <?= ($row['status_pembelian'] == 2 ? 'selected' : ''); ?>>Barang dikirim</option>
                  <option value="3" <?= ($row['status_pembelian'] == 3 ? 'selected' : ''); ?>>Barang Sudah Sampai</option>
                  <option value="4" <?= ($row['status_pembelian'] == 4 ? 'selected' : ''); ?>>Berhasil</option>
                  <option value="5" <?= ($row['status_pembelian'] == 5 ? 'selected' : ''); ?>>Gagal</option>
                </select>
            </div>
          </div>
        </div>

      </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script>
  $("#form-pembayaran").on('submit', function(e){
		// alert('jdk');
    e.preventDefault();
    	$.ajax({
    		method:  'post', 
    		url: "halaman/pembelian/proses.php",
        dataType: "json",
    		data: $(this).serialize(),
        beforeSend:function() {
          $('.btnsimpan').attr('disable', 'disabled');
          $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
        },
        complete:function(){
          $('.btnsimpan').removeAttr('disable');
          $('.btnsimpan').html('simpan');
        },
    		success:function(response){
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: response.sukses
          });
  
          $("#viewdata").empty();
          $("#viewdata").html(response.data);
          $("#modalpembayaran").modal('hide');
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



