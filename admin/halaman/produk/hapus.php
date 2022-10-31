<?php
// fungsi untuk membuat format json
// header('Content-Type: application/json');
include "../../../function.php";
    $id = htmlentities(strip_tags(trim($_POST['id'])));
    $nama_produk = htmlentities(strip_tags(trim($_POST['nama_produk'])));

    mysqli_query($conn, "DELETE FROM produk WHERE `id_produk` = $id");

    $cek = mysqli_query($conn, "SELECT * FROM foto_produk WHERE `id_produk` = $id");
    $cekfoto = mysqli_num_rows($cek);
    if ($cekfoto > 0) {
      $query2 = query("SELECT * FROM foto_produk WHERE `id_produk` = $id");
      foreach ($query2 as $q) {
        unlink('../../../assets/img/produk/'.$q['nama_foto_produk']);
        mysqli_query($conn, "DELETE FROM foto_produk WHERE `id_produk` = $id");
      }
    }

    $content = file_get_contents("$lokasi/admin/halaman/produk/dataproduk.php", true);
    $data = [
      'sukses'=>"Produk $nama_produk berhasil dihapus",
      'data'=> $content
    ];

    echo json_encode($data);