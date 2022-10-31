<?php 

include '../../../function.php';


$i = 1;
                $result = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli");
                foreach ($result as $data) :
  
                ?>
                  <tr>
                      <td><?= $i; ?></td>
                      <td><?= $data['id_pembelian']; ?></td>
                      <td><?= $data['nama_pembeli']; ?></td>
                      <td><?= date("d F Y", strtotime($data['tgl_pembelian'])); ?></td>
                      <td>Rp. <?= number_format($data['total_pembelian']); ?></td>
                      <td>
                        <?php if($data['status_pembelian'] == 1) { ?>
                        <nav class="badge badge-info">Sudah kirim pembayaran</nav>
                        <?php } elseif($data['status_pembelian'] == 2) { ?>
                          <nav class="badge badge-info">Barang dikirim</nav>
                        <?php } elseif($data['status_pembelian'] == 3) { ?>
                          <nav class="badge badge-success">Barang Sudah Sampai</nav>
                        <?php } elseif($data['status_pembelian'] == 4) { ?>
                          <nav class="badge badge-succes">Lunas</nav>
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