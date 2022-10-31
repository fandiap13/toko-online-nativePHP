<?php 

include '../../../function.php';
                
$i = 1;
              $result = query("SELECT * FROM produk INNER JOIN jenis ON produk.id_jenis = jenis.id_jenis ORDER BY produk.id_produk DESC");

              foreach ($result as $data) :

              ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><a href="../assets/img/produk/<?= $data['foto_produk']; ?>" class="perbesar"><img src="../assets/img/produk/<?= $data['foto_produk']; ?>" style="height:120px;"></a></td>
                    <td><?= $data['nama_produk']; ?></td>
                    <td><?= $data['jenis']; ?></td>
                    <td><?= $data['berat_produk']; ?> Kg</td>
                    <td>Rp. <?= number_format($data['harga_produk']); ?></td>
                    <td>
                      <a href="?halaman=produk&aksi=edit&id=<?= $data['id_produk']; ?>" class="btn btn-warning btn-circle"><i class="fas fa-tags"></i></a>

                      <button type="button" class="btn btn-danger btn-circle" onclick="hapus('<?= $data['id_produk']; ?>', '<?= $data['nama_produk']; ?>')">
                        <i class="fas fa-trash"></i>
                      </button>
                      
                      <a href="?halaman=produk&aksi=detail&id=<?= $data['id_produk']; ?>" class="btn btn-success btn-circle"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
              <?php
              $i++;
              endforeach; ?>