<?php

$ekspedisi = $_POST['ekspedisi'];
$distrik = $_POST['distrik'];
$berat = $_POST['berat'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  // toko di karanganyar
  CURLOPT_POSTFIELDS => "origin=169&destination=" . $distrik . "&weight=" . $berat . "&courier=" . $ekspedisi,
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
    "key: 2b944699d873d67666ab77aee71409ce"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $array_response = json_decode($response, true);
  $paket = $array_response['rajaongkir']['results']['0']['costs'];

  // echo "<pre>";
  // print_r($paket);
  // echo "</pre>";

  echo "<option value=''>--Pilih Paket--</option>";
  foreach ($paket as $key => $tiap_paket) {
    echo "<option
    paket = '" . $tiap_paket['service'] . "'
    ongkir = '" . $tiap_paket['cost']['0']['value'] . "'
    etd = '" . $tiap_paket['cost']['0']['etd'] . "'
    >";
    echo $tiap_paket['service'] . " ";
    echo "Rp. " . number_format($tiap_paket['cost']['0']['value']) . " ";
    echo $tiap_paket['cost']['0']['etd'];
    echo "</option>";
  }
}
