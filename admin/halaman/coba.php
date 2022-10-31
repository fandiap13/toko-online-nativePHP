
          <table width="100%" cellpadding="5" cellspacing="0">
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
                <th colspan="4" align="center">Total</th>
                <th>Rp. <?= number_format($total); ?></th>
              </tr>
            </tbody>
          </table>
