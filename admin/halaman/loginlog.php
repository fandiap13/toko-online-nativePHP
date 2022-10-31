<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Login Log</h4>
    </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Time</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Time</th>
              </tr>
            </tfoot>
            <tbody id="viewdata">
            <?php 

            $i = 1;
            $result = query("SELECT * FROM `login` INNER JOIN `users` ON `login`.`user_id` = `users`.`user_id` ORDER BY `login`.`id_login` DESC");
            foreach ($result as $data) :

            ?>
              <tr>
                  <td><?= $i; ?>.</td>
                  <td><?= $data['username']; ?></td>
                  <td><?= $data['nama_lengkap']; ?></td>
                  <td><?= date("d F Y, H:i", strtotime($data['tgl_login'])); ?></td>
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