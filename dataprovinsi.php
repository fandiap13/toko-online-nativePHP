<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "key: 2b944699d873d67666ab77aee71409ce"
  ),
));

$response = curl_exec($curl); 
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  // dapatnya dalam bentuk json
  // kita konferensi ke array dulu
  // echo $response;
  $array_response = json_decode($response, true);
  $dataprovinsi = $array_response['rajaongkir']['results'];

  // $d = $array_response['rajaongkir']['results'][9]['province'];
  // echo "<pre>";
  // print_r($d);
  // echo "</pre>";

  // option untuk halaman checkout
  echo "<option value=''>--Pilih Provinsi--</option>";
  foreach ($dataprovinsi as $key => $tiap_provinsi) 
  {
    echo "<option value='". $tiap_provinsi['province_id'] ."' id_provinsi='".$tiap_provinsi['province_id']."'>";
    echo $tiap_provinsi['province'];
    echo "</option>";
  }
}