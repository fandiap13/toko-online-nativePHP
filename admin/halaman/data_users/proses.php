<?php
// fungsi untuk membuat format json
// header('Content-Type: application/json');
include "../../../function.php";

$aksi = $_GET['aksi'];
// untuk load data yang sudah ada dari tabel

switch ($aksi) {
  case 'tambah':
    $username =  htmlentities(strip_tags(trim($_POST['username'])));
    $password =  htmlentities(strip_tags(trim($_POST['password'])));
    $password2 =  htmlentities(strip_tags(trim($_POST['password2'])));
    $nama_lengkap =  htmlentities(strip_tags(trim($_POST['nama_lengkap'])));
    $telp_user =  htmlentities(strip_tags(trim($_POST['telp_user'])));
    $jk_user =  htmlentities(strip_tags(trim($_POST['jk_user'])));
    $alamat_user =  htmlentities(strip_tags(trim($_POST['alamat_user'])));
    $email_user =  htmlentities(strip_tags(trim($_POST['email_user'])));
    $namaFile = $_FILES["foto"]["name"];
    $ukuran = $_FILES["foto"]["size"];
    $error = $_FILES["foto"]["error"];
    $tmp = $_FILES["foto"]["tmp_name"];
    $pesan_error_user = "";
    $pesan_error_pass = "";
    $pesan_error_aturan = "";
    $pesan_error_foto = "";
    $pesan_error_email = "";

    $query_username = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $result_username = mysqli_num_rows($query_username);
    if ($result_username > 0) {
      $pesan_error_user = "Username <b>$username</b> sudah digunakan <br>";
    }

    $query_email = mysqli_query($conn, "SELECT * FROM users WHERE email_user = '$email_user'");
    $result_email = mysqli_num_rows($query_email);
    if ($result_email > 0) {
      $pesan_error_email = "Email <b>$email_user</b> sudah digunakan <br>";
    }

    if ($password !== $password2) {
      $pesan_error_pass = "Retype password tidak sesuai <br>";
    }

    $aturan_pass1 = preg_match('@[A-Z]@', $password);
    $aturan_pass2 = preg_match('@[a-z]@', $password);
    $aturan_pass3 = preg_match('@[0-9]@', $password);

    if (!$aturan_pass1 || !$aturan_pass2 || !$aturan_pass3 || strlen($password) < 8) {
      $pesan_error_aturan = "Password setidaknya harus 8 karakter dan harus memiliki huruf besar, huruf kecil, angka";
    }

    // foto
    if ($error === 4) {
      $namafoto = 'default.svg';
    } else {
      $gambarvalid = ["jpg","jpeg","png"];
      $ekstensigambar = explode('.', $namaFile);
      $ekstensigambar = strtolower(end($ekstensigambar));
      if (!in_array($ekstensigambar, $gambarvalid)) {
        $pesan_error_foto = "Yang anda upload bukan gambar";
      }
      if ($ukuran > 2000000) {
        $pesan_error_foto = "Ukuran gambar terlalu besar";
      }
      $namafoto = uniqid();
      $namafoto .= '.';
      $namafoto .= $ekstensigambar;
    }

    if ($pesan_error_user !== "" || $pesan_error_pass !== "" || $pesan_error_foto !== "" || $pesan_error_aturan !== "" || $pesan_error_email !== "") {
      $data = [
        'error' => [
          'username' => $pesan_error_user,
          'password' => $pesan_error_pass,
          'aturan_error' => $pesan_error_aturan,
          'foto' => $pesan_error_foto,
          'email' => $pesan_error_email
        ]
      ];
      
    } else if ($pesan_error_user == "" && $pesan_error_pass == "" && $pesan_error_foto == "" && $pesan_error_aturan == "" && $pesan_error_email == ""){
      move_uploaded_file($tmp, '../../../assets/img/' .$namafoto);

      $userpass = password_hash($password, PASSWORD_DEFAULT);
      $query = mysqli_query($conn,"INSERT INTO `users` (`user_id`, `username`, `password`, `nama_lengkap`, `telp_user`, `jk_user`, `alamat_user`, `foto_user`, `email_user`) VALUES (NULL, '$username', '$userpass', '$nama_lengkap', '$telp_user', '$jk_user', '$alamat_user', '$namafoto', '$email_user')");
      $content = file_get_contents("$location/datausers.php", true);
      $data = [
        'sukses'=>"User dengan username $username berhasil ditambahkan",
        'data'=> $content
      ];
    }
    echo json_encode($data);
    break;

  case 'hapus':
    $id = htmlentities(strip_tags(trim($_POST['id'])));
    $username = htmlentities(strip_tags(trim($_POST['username'])));

    $query = mysqli_query($conn, "SELECT * FROM users WHERE `user_id` = $id");
    $row = mysqli_fetch_assoc($query);

    if ($row['foto_user'] !== 'default.svg') {
      unlink('../../../assets/img/'.$row['foto_user']);
    }
    
    $query = mysqli_query($conn, "DELETE FROM users WHERE `user_id` = $id");
    $content = file_get_contents("$location/datausers.php", true);
    if ($query) {
      $data = [
        'sukses'=>"User dengan username $username berhasil dihapus",
        'data'=> $content
      ];
    }

    echo json_encode($data);
    break;

  case 'edit':
    $id = htmlentities(strip_tags(trim($_POST['user_id'])));
    $username =  htmlentities(strip_tags(trim($_POST['username'])));
    $password =  htmlentities(strip_tags(trim($_POST['password'])));
    $password2 =  htmlentities(strip_tags(trim($_POST['password2'])));
    $nama_lengkap =  htmlentities(strip_tags(trim($_POST['nama_lengkap'])));
    $telp_user =  htmlentities(strip_tags(trim($_POST['telp_user'])));
    $jk_user =  htmlentities(strip_tags(trim($_POST['jk_user'])));
    $alamat_user =  htmlentities(strip_tags(trim($_POST['alamat_user'])));
    $foto_lama =  htmlentities(strip_tags(trim($_POST['foto_lama'])));
    $email_user =  htmlentities(strip_tags(trim($_POST['email_user'])));
    $namaFile = $_FILES["foto"]["name"];
    $ukuran = $_FILES["foto"]["size"];
    $error = $_FILES["foto"]["error"];
    $tmp = $_FILES["foto"]["tmp_name"];
    $pesan_error_user = "";
    $pesan_error_aturan = "";
    $pesan_error_pass = "";
    $pesan_error_foto = "";
    $pesan_error_email = "";

    $query_username = mysqli_query($conn, "SELECT * FROM users WHERE `user_id` = '$id'");
    $data = mysqli_fetch_assoc($query_username);
    $usernameLama = $data['username'];
    $emailLama = $data['email_user'];
    if ($usernameLama !== $username) {
      $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
      $row_username = mysqli_num_rows($query);
      if ($row_username > 0) {
        $pesan_error_user = "Username <b>$username</b> sudah digunakan <br>";
      }
    }
    if ($emailLama !== $email_user) {
      $query = mysqli_query($conn, "SELECT * FROM users WHERE email_user = '$email_user'");
      $row_email = mysqli_num_rows($query);
      if ($row_email > 0) {
        $pesan_error_email = "Email <b>$email_user</b> sudah digunakan <br>";
      }
    }

    if ($password !== "") {
      if ($password !== $password2) {
        $pesan_error_pass = "Retype password tidak sesuai <br>";
      }

      $aturan_pass1 = preg_match('@[A-Z]@', $password);
      $aturan_pass2 = preg_match('@[a-z]@', $password);
      $aturan_pass3 = preg_match('@[0-9]@', $password);
      if (!$aturan_pass1 || !$aturan_pass2 || !$aturan_pass3 || strlen($password) < 8) {
        $pesan_error_aturan = "Password setidaknya harus 8 karakter dan harus memiliki huruf besar, huruf kecil, angka";
      }
    }

    // foto
    if ($error === 4) {
      $namafoto = $foto_lama;
    } else {
      $gambarvalid = ["jpg","jpeg","png"];
      $ekstensigambar = explode('.', $namaFile);
      $ekstensigambar = strtolower(end($ekstensigambar));
      if (!in_array($ekstensigambar, $gambarvalid)) {
        $pesan_error_foto = "Yang anda upload bukan gambar";
      }
      if ($ukuran > 2000000) {
        $pesan_error_foto = "Ukuran gambar terlalu besar";
      }
      $namafoto = uniqid();
      $namafoto .= '.';
      $namafoto .= $ekstensigambar;
    }

    if ($pesan_error_user !== "" || $pesan_error_pass !== "" || $pesan_error_foto !== "" || $pesan_error_aturan !== "" || $pesan_error_email !== "") {
      $data = [
        'error' => [
          'username' => $pesan_error_user,
          'password' => $pesan_error_pass,
          'foto' => $pesan_error_foto,
          'aturan' => $pesan_error_aturan,
          'email' => $pesan_error_email
        ]
      ];
      
    } else if ($pesan_error_user == "" && $pesan_error_pass == "" && $pesan_error_foto == "" && $pesan_error_aturan == "" && $pesan_error_email == ""){
      // jika nama foto tidak sama dengan nama fotolama
      if ($namaFile !== "") {
        if ($foto_lama !== $namaFile && $foto_lama !== 'default.svg') {
          unlink('../../../assets/img/'.$foto_lama);
        }
      }

      move_uploaded_file($tmp, '../../../assets/img/' .$namafoto);

      if ($password !== "") {
        $userpass = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE `users` SET `username` = '$username', `password` = '$userpass', `nama_lengkap` = '$nama_lengkap', `telp_user` = '$telp_user', `jk_user` = '$jk_user', `alamat_user` = '$alamat_user', `foto_user` = '$namafoto', `email_user` = '$email_user' WHERE `users`.`user_id` = '$id'");
      } else {
        mysqli_query($conn, "UPDATE `users` SET `username` = '$username', `nama_lengkap` = '$nama_lengkap', `telp_user` = '$telp_user', `jk_user` = '$jk_user', `alamat_user` = '$alamat_user', `foto_user` = '$namafoto', `email_user` = '$email_user' WHERE `users`.`user_id` = '$id'");
      }
      
      $content = file_get_contents("$location/datausers.php", true);
      $data = [
        'sukses'=>"User dengan username $username berhasil diubah",
        'data'=> $content
      ];
    }
    echo json_encode($data);
    break;
}
