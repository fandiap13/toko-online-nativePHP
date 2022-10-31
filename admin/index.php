<?php 

include "../function.php";

if (!isset($_SESSION['login']) OR empty($_SESSION['login'])) {
	header('location: login.php');
	exit();
}
else if (isset($_SESSION['login'])) {
	if ($_SESSION['login'] !== 'user') {
		header('location: login.php');
		exit();
	}
}

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

// data users
$user_id = $_SESSION['user_id'];
$users = query("SELECT * FROM users WHERE user_id = '$user_id'")[0];


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin</title>

  <link href="../assets/img/favicon.png" rel="shortcut icon">

  <!-- Custom fonts for this template -->
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
  <!-- sweetalert -->
  <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  <link rel="stylesheet" href="../assets/sweeetalert2/dist/sweetalert2.min.css">
  <script src="../assets/sweeetalert2/dist/sweetalert2.all.min.js"></script>

  <!-- jquery -->
  <script src="../assets/vendor/jquery/jquery.min.js"></script>

  <!-- tiny mce -->
  <script src="../assets/tinymce/js/tinymce/tinymce.min.js"></script>

  <!-- <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script> -->

  <!-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
  <link rel="stylesheet" href="../assets/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
  <script src="../assets/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>

</head>

<body id="page-top">

<script>

  tinymce.init({
    selector: "#textarea",
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
  });
</script>

  <!-- Page Wrapper -->
  <div id="wrapper">

  <?php include "menu.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $users['username']; ?></span>
                <img class="img-profile rounded-circle" src="../assets/img/<?= $users['foto_user']; ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="?halaman=profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <?php 
        
        if (isset($_GET['halaman'])) {
          if ($_GET['halaman'] == "") {
            include "home.php";

          } elseif ($_GET['halaman'] == "data_users") {
            if ($_GET['aksi'] == "") {
              include "halaman/data_users/view_users.php";
            } elseif ($_GET['aksi'] == "datatable") {
              include "halaman/data_users/view_users2.php";
            }
            
          } elseif($_GET['halaman'] == "produk") {
            if ($_GET['aksi'] == "") {
              include "halaman/produk/view_produk.php";
            } elseif ($_GET['aksi'] == "detail") {
              include "halaman/produk/detail.php";
            } elseif ($_GET['aksi'] == "tambah") {
              include "halaman/produk/tambah.php";
            } elseif ($_GET['aksi'] == "hapusfotoproduk") {
              include "halaman/produk/hapusfotoproduk.php";
            } elseif ($_GET['aksi'] == "edit") {
              include "halaman/produk/edit.php";
            }
            
          } elseif($_GET['halaman'] == "datapembeli") {
            if ($_GET['aksi'] == "") {
              include "halaman/pembeli/view_pembeli.php";
            } elseif ($_GET['aksi'] == "datatable") {
              include "halaman/pembeli/view_pembeli2.php";
            }

          } elseif($_GET['halaman'] == "pembelian") {
            if ($_GET['aksi'] == "") {
              include "halaman/pembelian/view_pembelian.php";
            } elseif ($_GET['aksi'] == "detail") {
              include "halaman/pembelian/detail.php";
            } elseif ($_GET['aksi'] == "pending") {
              include "halaman/pembelian/view_pembelian_pending.php";
            } elseif ($_GET['aksi'] == "lunas") {
              include "halaman/pembelian/view_pembelian_lunas.php";
            } elseif ($_GET['aksi'] == "gagal") {
              include "halaman/pembelian/view_pembelian_gagal.php";
            } elseif ($_GET['aksi'] == "barangdikirim") {
              include "halaman/pembelian/view_pembelian_dikirim.php";
            } elseif ($_GET['aksi'] == "sudahbayar") {
              include "halaman/pembelian/view_pembelian_sudahbayar.php";
            }

          } elseif($_GET['halaman'] == "kategori") {
            if ($_GET['aksi'] == "") {
              include "halaman/kategori/view_jenis.php";
            } elseif ($_GET['aksi'] == "datatable") {
              include "halaman/kategori/view_jenis2.php";
            }
          
          } elseif($_GET['halaman'] == "toko") {
            if ($_GET['aksi'] == "") {
              include "halaman/toko/view_toko.php";
            } elseif ($_GET['aksi'] == "edit") {
              include "halaman/toko/edit.php";
            }
          
          } elseif($_GET['halaman'] == "laporan") {
            include "halaman/laporan.php";

          } elseif($_GET['halaman'] == "profile") {
            include "halaman/profile.php";

          } elseif($_GET['halaman'] == "loginlog") {
            include "halaman/loginlog.php";

          } elseif($_GET['halaman'] == "download_laporan") {
            include "halaman/download_laporan.php";

          } else {
            include "blocked.php";
          }

        }else{
          include "home.php";
        }
        
        ?>
        
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; toko-fandi <?= date('Y'); ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Log Out</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Apakah anda yakin ingin Log Out ?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <!-- <script src="../assets/vendor/jquery/jquery.min.js"></script> -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../assets/js/demo/datatables-demo.js"></script>

  <script>
      $(document).ready(function() {
        $('.perbesar').fancybox();
      });
  </script>

  <?php if(isset($_SESSION['alert'])) { ?>
    <?php if($_SESSION['alert'] == true) { ?>
      <script>
          const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 5000
          });

          setTimeout(function() {
            Toast.fire({
              icon: 'success',
              title: "Selamat datang, <?= $_SESSION['username']; ?>",
          });
          },500);
      </script>
    <?php } ?>
  <?php unset($_SESSION['alert']); ?>
  <?php } ?>

  <script>
    function previewFoto(){
      const foto = document.querySelector('#foto');
      const imgPreview = document.querySelector('.img-preview');

      const fileFoto = new FileReader();
      fileFoto.readAsDataURL(foto.files[0]);
      fileFoto.onload = function(e) {
      imgPreview.src = e.target.result;
      }
    }

    function previewFoto2(){
      const foto = document.querySelector('#foto2');
      const imgPreview = document.querySelector('.img-preview2');

      const fileFoto = new FileReader();
      fileFoto.readAsDataURL(foto.files[0]);
      fileFoto.onload = function(e) {
      imgPreview.src = e.target.result;
      }
    }

  </script>

</body>

</html>