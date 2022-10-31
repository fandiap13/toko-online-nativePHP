<?php 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


include "PHPMailer/src/PHPMailer.php";
include "PHPMailer/src/Exception.php";
include "PHPMailer/src/OAuth.php";
include "PHPMailer/src/POP3.php";
include "PHPMailer/src/SMTP.php";

$mail = new PHPMailer;

$isi_email = "Seseorang meminta untuk melakukan perubahan password, silahkan klik link di bawah ini:";
$isi_email .= "/ubahpass.php?email=&token=";

//Enable SMTP debugging.
//$mail->SMTPDebug = 3;
//Set PHPMailer to use SMTP.
$mail->isSMTP();
//Set SMTP host name
$mail->Host = "tls://smtp.gmail.com"; //host mail server
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;
//Provide username and password
$mail->Username = "crewpucksapi@gmail.com";   //nama-email smtp
$mail->Password = "crewpuck_123";           //password email smtp
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "ssl";
//Set TCP port to connect to
$mail->Port = 587;

$mail->From = "crewpucksapi@gmail.com"; //email pengirim
$mail->FromName = "crewpucksapi@gmail.com"; //nama pengirim

$mail->addAddress('mailshop2002@gmail.com'); //email penerima

$mail->isHTML(true);

$mail->Subject = 'coba'; //subject
$mail->Body    = $isi_email; //isi email
$mail->AltBody = "ubahpass"; //body email

if(!$mail->send())
{
echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
echo "Message has been sent successfully";
}

?>
