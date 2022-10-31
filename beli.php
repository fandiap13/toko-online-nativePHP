<?php 

include "function.php";

loginpengunjung();

$id_produk = $_GET['id'];
$cekproduk = query("SELECT * FROM produk WHERE id_produk = '$id_produk'")[0];
$status = $cekproduk['status_produk'];
$nama_produk = $cekproduk['nama_produk'];

if ($status == 'Tidak tersedia') {
  echo "<script>
  alert('$nama_produk tidak tersedia');
  window.location.href='daftarproduk.php';
  </script>";
} else {
  // index menggunakan id produk jmlnya 1
  // $keranjang[$id_produk] = 1;
  
  // jika sudah ada produk itu dikeranjang, maka jmlnya tambah 1
  if (isset($_SESSION['keranjang'][$id_produk])) {
    $_SESSION['keranjang'][$id_produk]+=1;
  }
  // jika belum ada
  else {
    $_SESSION['keranjang'][$id_produk] = 1;
  }
  
  // echo "<pre>";
  // print_r($_SESSION);
  // echo "</pre>";
  
  echo "<script>
  alert('$nama_produk telah masuk ke keranjang belanja');
  window.location.href='keranjang.php';
  </script>";

}

?>