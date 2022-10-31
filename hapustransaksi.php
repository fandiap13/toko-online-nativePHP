<?php 

include "function.php";

loginpengunjung();

$id_transaksi = $_GET['id'];

// transaksi
$trans = query("SELECT * FROM pembelian WHERE id_pembelian = '$id_transaksi'")[0];
$id_pembeli_transaksi = $trans['id_pembeli'];
$id_pembeli = $_SESSION['id_pembeli'];

// pembayaran
$querypembayaran = mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pembelian = '$id_transaksi'");
$pemba = mysqli_num_rows($querypembayaran);
$datapem = mysqli_fetch_assoc($querypembayaran);

if ($id_pembeli !== $id_pembeli_transaksi) {
  echo "
  <script>
  alert('Jangan Nakal Kamu Ya !');
  window.location.href = 'transaksi.php';
  </script>
  ";
} else {
  if ($pemba > 0) {
    // mengecek status pembelian
    // bisa menghapus jika status gagal
    if ($trans['status_pembelian'] == 5) {
      unlink('assets/img/bukti/'.$datapem['bukti']);
    
      mysqli_query($conn, "DELETE FROM `pembelian` WHERE `id_pembelian` = '$id_transaksi'");
      mysqli_query($conn, "DELETE FROM `pembelian_produk` WHERE `id_pembelian` = '$id_transaksi'");
      mysqli_query($conn, "DELETE FROM `pembayaran` WHERE `id_pembelian` = '$id_transaksi'");
    
      echo "<script>
            alert('Transaksi $id_transaksi berhasil dihapus');
            window.location.href = 'transaksi.php';
            </script>
            ";
    } else {
      echo "
      <script>
      alert('Anda tidak bisa menghapus transaksi jika sudah mengirim bukti pembayaran !');
      window.location.href = 'transaksi.php';
      </script>
      ";
    }

  } else {
    mysqli_query($conn, "DELETE FROM `pembelian` WHERE `id_pembelian` = '$id_transaksi'");
    mysqli_query($conn, "DELETE FROM `pembelian_produk` WHERE `id_pembelian` = '$id_transaksi'");
  
    echo "<script>
          alert('Transaksi $id_transaksi berhasil dihapus');
          window.location.href = 'transaksi.php';
          </script>
          ";
  }
}


?>