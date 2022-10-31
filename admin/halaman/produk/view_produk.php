
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h4 class="m-0 font-weight-bold">Data Produk</h4>
    </div>
    <div class="card-header py-3" style="background-color: #fff;">
      <a href="?halaman=produk&aksi=tambah" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Produk</a>
      
    </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Foto Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Berat (Gr)</th>
                <th>Harga (Rp)</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
              <th>No.</th>
              <th>Foto Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Berat (Gr)</th>
                <th>Harga (Rp)</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody id="viewdata">
            <?php 
                
              $i = 1;
              $result = query("SELECT * FROM produk INNER JOIN jenis ON produk.id_jenis = jenis.id_jenis ORDER BY produk.id_produk DESC");

              foreach ($result as $data) :

              ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><a href="../assets/img/produk/<?= $data['foto_produk']; ?>" class="perbesar"><img src="../assets/img/produk/<?= $data['foto_produk']; ?>" style="height:120px;"></a></td>
                    <td><?= $data['nama_produk']; ?></td>
                    <td><?= $data['jenis']; ?></td>
                    <td><?= number_format($data['berat_produk']); ?> Gram</td>
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
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
  // hapus data
  function hapus(id, nama_produk) {
    Swal.fire({
    title: 'Hapus',
    text: `Yakin menghapus data Produk ${nama_produk} ?`,
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
          url: "halaman/produk/hapus.php",
          data: {
            id:id,
            nama_produk: nama_produk
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
</script>