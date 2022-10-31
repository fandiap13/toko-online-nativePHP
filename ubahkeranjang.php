<?php 

include "function.php";

loginpengunjung();

$id_produk = $_POST['id_produk'];
$jml_tambah = $_POST['tambah']; 

$cekproduk = query("SELECT * FROM produk WHERE id_produk = '$id_produk'")[0];
$status = $cekproduk['status_produk'];
$nama_produk = $cekproduk['nama_produk'];

if ($status == 'Tidak tersedia') {
  unset($_SESSION['keranjang'][$id_produk]);
  
  echo "<script>
  alert('$nama_produk sudah tidak tersedia');
  window.location.href='daftarproduk.php';
  </script>";
  
} else {
  if (isset($_SESSION['keranjang'][$id_produk])) {
    $_SESSION['keranjang'][$id_produk] = $jml_tambah;
    echo "<script>
          window.location.href = 'keranjang.php';
          </script>
          ";
  }
}

?>