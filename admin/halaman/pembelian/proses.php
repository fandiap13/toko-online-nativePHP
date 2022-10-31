<?php

include "../../../function.php";

$status_pembelian = $_POST['status_pembelian'];
$no_resi = $_POST['no_resi'];
$id_pembelian = $_POST['id_pembelian'];

mysqli_query($conn, "UPDATE `pembelian` SET `status_pembelian` = '$status_pembelian', `no_resi` = '$no_resi' WHERE `pembelian`.`id_pembelian` = '$id_pembelian'");

$content = file_get_contents("$location/datapembelian.php", true);
$data = [
  'sukses'=>"Data transaksi dengan ID $id_pembelian berhasil diupdate",
  'data'=> $content
];

echo json_encode($data);


