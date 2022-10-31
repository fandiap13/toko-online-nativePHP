<?php

include "../../../function.php";

$aksi = $_GET['aksi'];
// $lokasi = "http://localhost/toko-online";

switch ($aksi) {
  case 'tambah':
    $jenis =  htmlentities(strip_tags(trim($_POST['jenis'])));
    $pesan_error_jenis = "";

    $query_jenis = mysqli_query($conn, "SELECT * FROM `jenis` WHERE jenis = '$jenis'");
    $result_jenis = mysqli_num_rows($query_jenis);

    if ($result_jenis > 0) {
      $pesan_error_jenis = "Kategori <b>$jenis</b> sudah ada <br>";
    }

    if ($pesan_error_jenis !== "") {
      $data = [
        'error' => [
          'jenis' => $pesan_error_jenis
        ]
      ];
      
    } else if ($pesan_error_jenis == ""){
      $query = mysqli_query($conn,"INSERT INTO `jenis` (`id_jenis`, `jenis`) VALUES (NULL, '$jenis')");
      $content = file_get_contents("$location/datajenis.php", true);
      $data = [
        'sukses'=>"Kategori $jenis berhasil ditambahkan",
        'data'=> $content
      ];
    }
    echo json_encode($data);
    break;

  case 'hapus':
    $id = htmlentities(strip_tags(trim($_POST['id'])));
    $jenis = htmlentities(strip_tags(trim($_POST['jenis'])));

    $query = mysqli_query($conn, "DELETE FROM jenis WHERE `id_jenis` = $id");
    $content = file_get_contents("$location/datajenis.php", true);
    if ($query) {
      $data = [
        'sukses'=>"Kategori $jenis berhasil dihapus",
        'data'=> $content
      ];
    }

    echo json_encode($data);
    break;

  case 'edit':
    $id = htmlentities(strip_tags(trim($_POST['id_jenis'])));
    $jenis =  htmlentities(strip_tags(trim($_POST['jenis'])));
    $pesan_error_jenis = "";

    $query_jenis = mysqli_query($conn, "SELECT * FROM jenis WHERE `id_jenis` = '$id'");
    $data = mysqli_fetch_assoc($query_jenis);
    $jenisLama = $data['jenis'];
    if ($jenisLama !== $jenis) {
      $query = mysqli_query($conn, "SELECT * FROM jenis WHERE jenis = '$jenis'");
      $row_jenis = mysqli_num_rows($query);
      if ($row_jenis > 0) {
        $pesan_error_jenis = "Kategori <b>$jenis</b> sudah ada <br>";
      }
    }

    if ($pesan_error_jenis !== "") {
      $data = [
        'error' => [
          'jenis' => $pesan_error_jenis,
        ]
      ];
      
    } else if ($pesan_error_jenis == ""){
      mysqli_query($conn, "UPDATE `jenis` SET `jenis` = '$jenis' WHERE `jenis`.`id_jenis` = '$id'");
      
      $content = file_get_contents("$location/datajenis.php", true);
      $data = [
        'sukses'=>"Kategori $jenis berhasil diubah",
        'data'=> $content
      ];
    }
    echo json_encode($data);
    break;
}
