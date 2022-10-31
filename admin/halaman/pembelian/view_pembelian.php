<?php 

if (isset($_POST['cari'])) {
  $status = $_POST['status'];
  $result = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli WHERE status_pembelian = '$status'");
} else {
  $status = "";
  $result = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli");
}

?>


<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Data Pembelian</h4>
      <!-- <h1 class="h3 mb-2 text-gray-800">Data Users</h1> -->
    </div>
    <div class="card-header py-3" style="background-color: #fff;">
      <form method="post">
        <div class="row">
          <div class="col-md-6">
            <label for="tgl_selesai" class="form-label">Status</label>
            <select name="status" class="form-control">
              <option value="0" <?= ($status == 0) ? 'selected' : ''; ?>>Belum dibayar</option>
              <option value="6" <?= ($status == 6) ? 'selected' : ''; ?>>Diproses Penjual</option>
              <option value="1" <?= ($status == 1) ? 'selected' : ''; ?>>Sudah kirim pembayaran</option>
              <option value="2" <?= ($status == 2) ? 'selected' : ''; ?>>Barang dikirim</option>
              <option value="3" <?= ($status == 3) ? 'selected' : ''; ?>>Barang sudah sampai</option>
              <option value="4" <?= ($status == 4) ? 'selected' : ''; ?>>Berhasil</option>
              <option value="5" <?= ($status == 5) ? 'selected' : ''; ?>>Gagal</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">&nbsp;</label><br>
            <button type="submit" name="cari" class="btn btn-primary"><i class="fa fa-store"></i> Cari</button>
          </div>
        </div>
      </form>
    </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                  <th>No.</th>
                  <th>ID Transaksi</th>
                  <th>Nama Pembeli</th>
                  <th>Tgl Pembelian</th>
                  <th>Total Pembelian</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No.</th>
                  <th>ID Transaksi</th>
                  <th>Nama Produk</th>
                  <th>Tgl Pembelian</th>
                  <th>Total Pembelian</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody id="viewdata">
            <?php 
                
                $i = 1;
                foreach ($result as $data) :
  
                ?>
                  <tr>
                      <td><?= $i; ?></td>
                      <td><?= $data['id_pembelian']; ?></td>
                      <td><?= $data['nama_pembeli']; ?></td>
                      <td><?= date("d F Y, H:i", strtotime($data['tgl_pembelian'])); ?></td>
                      <td>Rp. <?= number_format($data['total_pembelian']); ?></td>
                      <td>
                        <?php if($data['status_pembelian'] == 1) { ?>
                        <nav class="badge badge-info">Sudah kirim pembayaran</nav>
                        <?php } elseif($data['status_pembelian'] == 2) { ?>
                          <nav class="badge badge-info">Barang dikirim</nav>
                        <?php } elseif($data['status_pembelian'] == 3) { ?>
                          <nav class="badge badge-success">Barang Sudah Sampai</nav>
                        <?php } elseif($data['status_pembelian'] == 4) { ?>
                          <nav class="badge badge-success">Berhasil</nav>
                        <?php } elseif($data['status_pembelian'] == 5) { ?>
                          <nav class="badge badge-danger">Gagal</nav>
                        <?php } elseif($data['status_pembelian'] == 6) { ?>
                          <nav class="badge badge-warning">Diproses Penjual</nav>
                        <?php } else { ?>
                          <nav class="badge badge-warning">Belum dibayar</nav>
                        <?php } ?>
                      </td>
                      <td class="text-center">
                        <a href="?halaman=pembelian&aksi=detail&id=<?= $data['id_pembelian']; ?>" class="btn btn-success mb-2"><i class="fas fa-eye"></i> Detail</a>

                        <br>
                        <?php if ($data['status_pembelian'] <> 0) { ?>
                          <button type="button" class="btn btn-primary" onclick="pembayaran('<?= $data['id_pembelian']; ?>')">
                            <i class="fas fa-money-bill"></i> Pembayaran
                          </button>
                        <?php } ?>
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

<div class="viewmodal" style="display: none;"></div>

<script>
  // // tampil detail
  // function detail(id) {
  //   $.ajax({
  //     type: 'POST',
  //     url: 'halaman/pembelian/detail.php',
  //     data: {
  //       id: id
  //     },
  //     success: function (response) {
  //       console.log(response);
  //       $('.viewmodal').html(response).show();
  //       $('#modaldetail').modal('show');
  //     },
  //     error: function(xhr, ajaxOptions, thrownError){
  //       alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
  //     }
  //   });
  // }

  function pembayaran(id) {
    $.ajax({
      type: 'POST',
      url: 'halaman/pembelian/pembayaran.php',
      data: {
        id: id
      },
      success: function (response) {
        console.log(response);
        $('.viewmodal').html(response).show();
        $('#modalpembayaran').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError){
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

</script>