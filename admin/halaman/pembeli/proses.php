<?php

include "../../../function.php";

$aksi = $_GET['aksi'];

if ($aksi == "hapus") {
    $id = htmlentities(strip_tags(trim($_POST['id'])));
    $username = htmlentities(strip_tags(trim($_POST['username'])));

    $query = mysqli_query($conn, "SELECT * FROM pembeli WHERE `id_pembeli` = $id");
    $row = mysqli_fetch_assoc($query);

    if ($row['foto_pembeli'] !== 'default.svg') {
      unlink('../../../assets/img/'.$row['foto_pembeli']);
    }

    $query = mysqli_query($conn, "DELETE FROM pembeli WHERE `id_pembeli` = $id");
    $content = file_get_contents("$location/datapembeli.php", true);
    if ($query) {
      $data = [
        'sukses'=>"Data pembembeli dengan username $username berhasil dihapus",
        'data'=> $content
      ];
    }

    echo json_encode($data);
}