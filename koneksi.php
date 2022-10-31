<?php 

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "db_toko_online";

$conn = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);

// setting waktu WIB
date_default_timezone_set("Asia/Jakarta");

$nmserver =  $_SERVER['SERVER_NAME'];
$peyimpanan = dirname($_SERVER['SCRIPT_NAME']);

$peyimpanan2 = "/toko-online";
$lokasi = "http://".$nmserver.$peyimpanan2;

$location = "http://".$nmserver.$peyimpanan;
// $lokasi = "http://".$nmserver.$peyimpanan;
// exit();