<?php 

$id_foto = $_GET['idf'];
$id_produk = $_GET['idp'];

$ambilfoto = query("SELECT * FROM foto_produk WHERE id_foto_produk = '$id_foto'")[0];
// print_r($ambilfoto);
unlink('../assets/img/produk/'.$ambilfoto['nama_foto_produk']);

// hapus data
mysqli_query($conn, "DELETE FROM foto_produk WHERE id_foto_produk = '$id_foto'");

echo "
      <script>
        setTimeout(function() {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            timer: 2200,
            text: 'Foto berhasil dihapus',
            confirmButtonText: 'Ok',
          });
        },10);
        window.setTimeout(function() {
          window.location.href = '?halaman=produk&aksi=detail&id=$id_produk';
        },3000);
      </script>
    ";

?>