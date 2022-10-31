<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Data Toko</h4>
    </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Foto Toko</th>
                <th>Tentang Kami</th>
                <th>Alamat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No.</th>
                <th>Foto Toko</th>
                <th>Tentang Kami</th>
                <th>Alamat</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody id="viewdata">
            <?php 
                
              $i = 1;
              $result = query("SELECT * FROM toko");
              foreach ($result as $data) :

              ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><a href="../assets/img/toko/<?= $data['foto']; ?>" class="perbesar"><img src="../assets/img/toko/<?= $data['foto']; ?>" style="height: 150px;"></a></td>
                    <td><?= $data['tentang_kami']; ?></td>
                    <td><?= $data['alamat']; ?></td>
                    <td>
                      <a href="?halaman=toko&aksi=edit&id=<?= $data['id']; ?>" class="btn btn-warning btn-circle"><i class="fas fa-tags"></i></a>
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