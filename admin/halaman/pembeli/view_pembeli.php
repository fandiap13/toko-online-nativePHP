<div class="container-fluid">
  <!-- Page Heading -->
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Data Pembeli</h4>
    </div>
    <div class="card-header py-3" style="background-color: #fff;">
      <a href="?halaman=datapembeli&aksi=datatable" class="btn btn-success"><i class="fas fa-table"></i> Data Table</a>
    </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Foto</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No.</th>
                <th>Foto</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody id="viewdata">
            <?php 

            $i = 1;
            $result = query("SELECT * FROM pembeli ORDER BY `id_pembeli` DESC");
            foreach ($result as $data) :

            ?>
              <tr>
                  <td><?= $i; ?>.</td>
                  <td><a href="../assets/img/<?= $data['foto_pembeli']; ?>" class="perbesar"><img src="../assets/img/<?= $data['foto_pembeli']; ?>" style="width: 100px;"></a></td>
                  <td><?= $data['username_pembeli']; ?></td>
                  <td><?= $data['nama_pembeli']; ?></td>
                  <td><?= $data['jk_pembeli']; ?></td>
                  <td>
                    <button type="button" class="btn btn-danger btn-circle" onclick="hapus('<?= $data['id_pembeli']; ?>','<?= $data['username_pembeli']; ?>')">
                      <i class="fas fa-trash"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-circle" onclick="detail('<?= $data['id_pembeli']; ?>')">
                      <i class="fas fa-eye"></i>
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

<div class="viewmodal" style="display: none;"></div>

<script>
  function hapus(id, username) {
    Swal.fire({
    title: 'Hapus',
    text: `Yakin menghapus data pembeli dengan username ${username} ?`,
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
          url: "halaman/pembeli/proses.php?aksi=hapus",
          data: {
            id:id,
            username: username
          },
          dataType: "json",
          success: function (response){
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

  // tampil detail
  function detail(id) {
    $.ajax({
      type: 'POST',
      url: 'http://localhost/toko-online/admin/halaman/pembeli/detail.php',
      data: {
        id: id
      },
      success: function (response) {
        console.log(response);
        $('.viewmodal').html(response).show();
        $('#modaldetail').modal('show');
      },
      error: function(xhr, ajaxOptions, thrownError){
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  }

</script>