<?php

include "../../function.php";

require_once '../../vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();


$id_pembelian = $_GET['id'];

// data toko
$toko = query("SELECT * FROM toko")[0];

$datatransaksi = query("SELECT * FROM pembelian INNER JOIN pembeli ON pembelian.id_pembeli = pembeli.id_pembeli WHERE pembelian.id_pembelian = '$id_pembelian'")[0];
$tgl_transaksi = $datatransaksi['tgl_pembelian'];
$id_pembeli_transaksi = $datatransaksi['id_pembeli'];
$status_pembelian = $datatransaksi['status_pembelian'];

$transaksi = query("SELECT * FROM pembelian_produk INNER JOIN pembelian ON pembelian_produk.id_pembelian = pembelian.id_pembelian INNER JOIN produk ON pembelian_produk.id_produk = produk.id_produk INNER JOIN jenis ON produk.id_jenis = jenis.id_jenis WHERE pembelian_produk.id_pembelian = '$id_pembelian'");

$totalpembelian = 0;

// pembelian
$resi = query("SELECT * FROM pembelian WHERE id_pembelian = '$id_pembelian'")[0];
$no_resi = $resi['no_resi'];

// cari data pembayaran
$query_pem = mysqli_query($conn, "SELECT * FROM pembayaran WHERE id_pembelian = '$id_pembelian'");
$cek = mysqli_num_rows($query_pem);
$pem = mysqli_fetch_assoc($query_pem);

$html = "";

$html .= '<h2>Detail Pembelian</h2>
<h3>Pembelian</h3>
<ul>
              <li><b>ID Transaksi : </b>'.$id_pembelian.'</li>
';

$html .= " <li><b>Tanggal Transaksi : </b>".date("d F Y, H:i", strtotime($resi['tgl_pembelian']))."</li>
              <li><b>Total Pembayaran : </b>Rp. ".number_format($resi['total_pembelian'])."</li>
              <li><b>Status : </b>
          ";
          
                        if($resi['status_pembelian'] == 1) {
                $html .= "        Sudah kirim pembayaran";
                        } elseif($resi['status_pembelian'] == 2) {
                $html .= "          Barang dikirim";
                        } elseif($resi['status_pembelian'] == 3) {
                $html .= "          Barang Sudah Sampai";
                        } elseif($resi['status_pembelian'] == 4) {
                $html .= "          Berhasil";
                        } elseif($resi['status_pembelian'] == 5) {
                $html .= "          Gagal";
                        } elseif($resi['status_pembelian'] == 6) {
                $html .= "          Diproses Penjual";
                        } else {
                $html .= "          Belum dibayar";
                        }

$html .= '</li></ul>
            <h3>Pembeli</h3>
            <ul>
              <li><b>Username : </b>'.$datatransaksi['username_pembeli'].'</li>
              <li><b>Pembeli :	</b>'.$datatransaksi['nama_pembeli'].'</li>
              <li><b>Jenis Kelamin :	</b>'.$datatransaksi['jk_pembeli'].'</li>
              <li><b>No. Telp / WA :	</b>'.$datatransaksi['telp_pembeli'].'</li>
              <li><b>E-mail :	</b>'.$datatransaksi['email_pembeli'].'</li>
          </ul>
          <h3>Pengiriman</h3>
          <ul>
              <li><b>Alamat Toko : </b>'.$toko['alamat'].'</li>
              <li><b>Ongkos Pengiriman : </b> Rp. '.number_format($datatransaksi['ongkir']).'</li>
              <li>
                <b>Ekspedisi : </b>'.$datatransaksi['ekspedisi'].' '.$datatransaksi['paket'].'  '.$datatransaksi['estimasi'].' Hari
              </li>
              <li>
                <b>Alamat Pengiriman :</b> '.$datatransaksi['alamat_pengiriman'].'
              </li>
          </ul>

            <table width="100%" cellspacing="0" cellpadding = "5" border="1">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Gambar</th>
                      <th>Produk</th>
                      <th>Jumlah</th>
                      <th>Subtotal</th>
                      <th>Kategori</th>
                    </tr>
                  </thead>
';
                  
                    $i = 1;
                    foreach ($transaksi as $t) :
                    $subberat = $t['jml_pembelian'] * $t['berat_produk'];
                  
$html .= '<tr>
                      <th>'.$i.'. </th>
                      <td class="product-thumb">
                        <img width="120px" height="auto" src="../../assets/img/produk/'.$t['foto_produk'].'" alt="image description">
                      </td>
                      <td class="product-details">
                        <p><b>'.$t['nama_produk'].'</b></p>
                        <b>Subberat </b>'.number_format($subberat).' Gram<br>
                      </td>
                      <td>'.$t['jml_pembelian'].' Buah</td>
                      <td>Rp. '.number_format($t['total']).'</td>
                      <td>'.$t['jenis'].'</span></td>
                    </tr>
                  ';

                  $i++;
                  $totalpembelian += $t['total'];
                  endforeach;

  $html .= "   </tbody>
            </table>";

// echo $html;


$mpdf->WriteHTML($html);
$mpdf->Output('detailpembelian.pdf', \Mpdf\Output\Destination::INLINE);