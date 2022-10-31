<?php 

if (isset($_POST['cari'])) {
  $tgl_mulai = $_POST['tgl_mulai'];
  $tgl_selesai = $_POST['tgl_selesai'];
  $status = $_POST['status'];
  if($status == "") {
    $result = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli WHERE tgl_pembelian BETWEEN '$tgl_mulai' AND '$tgl_selesai'");
  } else {
    $result = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli WHERE tgl_pembelian BETWEEN '$tgl_mulai' AND '$tgl_selesai' AND status_pembelian = '$status'");
  }
  $judul = '<h4 class="m-0 font-weight-bold">Laporan Transaksi Pembelian dari "'.date("d F Y", strtotime($tgl_mulai)).'" hingga "'.date("d F Y", strtotime($tgl_selesai)).'"</h4>';
} else {
  $tgl_mulai = "";
  $tgl_selesai = "";
  $status = "";
  $result = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli");
  $judul = '<h4 class="m-0 font-weight-bold">Laporan Transaksi Pembelian</h4>';
}

?>

<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <?= $judul; ?>
      <!-- <h1 class="h3 mb-2 text-gray-800">Data Users</h1> -->
    </div>
    <div class="card-header py-3" style="background-color: #fff;">
      <form method="post">
        <div class="row">
          <div class="col-md-3">
            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai; ?>" id="tgl_mulai" required>
          </div>
          <div class="col-md-3">
            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai; ?>" id="tgl_selesai" required>
          </div>
          <div class="col-md-3">
            <label for="tgl_selesai" class="form-label">Status</label>
            <select name="status" class="form-control">
              <option value="">-- Pilih Status --</option>
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
            <button type="submit" name="cari" class="btn btn-primary"><i class="fa fa-tasks"></i> Lihat laporan</button>
          </div>
        </div>
      </form>
      <a href="halaman/download_laporan.php?tglm=<?= $tgl_mulai; ?>&tgls=<?= $tgl_selesai; ?>&status=<?= $status; ?>" target="_blank" class="btn btn-success mt-3"><i class="fas fa-download fa-sm"></i> Download PDF</a>
    </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
                <tr>
                  <th>No.</th>
                  <th>ID Transaksi</th>
                  <th>Nama Pembeli</th>
                  <th>Tgl Pembelian</th>
                  <th>Total Pembelian</th>
                  <th>Status</th>
                </tr>
              </thead>
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
                  </tr>
                <?php
                $total += $data['total_pembelian'];
                $i++;
                endforeach; ?>
            </tbody>
            <tbody>
              <tr>
                <th colspan="4" class="text-center">Total</th>
                <th>Rp. <?= number_format($total); ?></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>