<?php 

session_start();
include 'koneksi.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "PHPMailer/src/PHPMailer.php";
include "PHPMailer/src/Exception.php";
include "PHPMailer/src/OAuth.php";
include "PHPMailer/src/POP3.php";
include "PHPMailer/src/SMTP.php";
include "vendor/autoload.php";

// untuk email pendaftaran dan ubah pass
$email_kami = "crewpucksapi@gmail.com";
$password_email_kami = "crewpuck_123";
$nama_email_kami = "crew puck";


function query($query) {
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

function loginpengunjung() {
  if (!isset($_SESSION['login']) OR empty($_SESSION['login'])) {
    header('location: login.php');
    exit();
  }
  else if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] !== 'pembeli') {
      header('location: login.php');
      exit();
    }
  }
}

// php mailer
function email($email_pembeli, $judul_email, $isi_email, $proses_berhasil){
  global $email_kami;
  global $nama_email_kami;
  global $password_email_kami;

    $mail = new PHPMailer();
    //Enable SMTP debugging.
    // $mail->SMTPDebug = 3;
    //Set PHPMailer to use SMTP.
    $mail->isSMTP();
    //Set SMTP host name
    $mail->Host = "tls://smtp.gmail.com"; //host mail server
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;
    //Provide username and password
    $mail->Username = $email_kami;   //nama-email smtp
    $mail->Password = $password_email_kami;           //password email smtp
    //If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = "ssl";
    //Set TCP port to connect to
    $mail->Port = 587;

    $mail->From = $email_kami; //email pengirim
    $mail->FromName = $nama_email_kami; //nama pengirim

    $mail->addAddress($email_pembeli); //email penerima

    $mail->isHTML(true);

    $mail->Subject = $judul_email; //subject
    $mail->Body    = $isi_email; //isi email
    $mail->AltBody = $judul_email; //body email

    if(!$mail->send()) {
      return "Gagal: " . $mail->ErrorInfo;
    } else {
      return $proses_berhasil;
    }
}