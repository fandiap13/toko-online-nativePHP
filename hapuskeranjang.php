<?php 

include "function.php";

loginpengunjung();

$id_produk = $_GET['id'];
$nama_produk = $_GET['produk'];
// $nama_produk = query("SELECT * FROM produk WHERE id_jenis = '$id_produk'")[0];
unset($_SESSION['keranjang'][$id_produk]);

echo "<script>
      alert('Produk $nama_produk dihapus dari keranjang');
      window.location.href = 'keranjang.php';
      </script>
      ";

?>