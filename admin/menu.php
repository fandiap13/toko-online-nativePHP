<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center mb-2 mt-2" href="index.php">
  <!-- <div class="sidebar-brand-icon rotate-n-15"> -->
		<img src="../assets/img/logo.png" width="85%" style="background-color: white; padding:5px;">
  <!-- </div> -->
  <!-- <div class="sidebar-brand-text mx-3">Menu Admin</div> -->
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?= ($_GET['halaman'] == '') ? 'active' : ''; ?>">
  <a class="nav-link" href="index.php">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?= ($_GET['halaman'] == 'toko') ? 'active' : ''; ?>">
  <a class="nav-link" href="?halaman=toko">
    <i class="fas fa-fw fa-file-alt"></i>
    <span>Toko</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Charts -->
<li class="nav-item <?= ($_GET['halaman'] == 'data_users') ? 'active' : ''; ?>">
  <a class="nav-link" href="?halaman=data_users">
    <i class="fas fa-fw fa-user-tie"></i>
    <span>Data Users</span></a>
</li>

<!-- Nav Item - Charts -->
<li class="nav-item <?= ($_GET['halaman'] == 'kategori') ? 'active' : ''; ?>">
  <a class="nav-link" href="?halaman=kategori">
    <i class="fas fa-fw fa-key"></i>
    <span>Kategori</span></a>
</li>

<li class="nav-item <?= ($_GET['halaman'] == 'produk') ? 'active' : ''; ?>">
  <a class="nav-link" href="?halaman=produk">
    <i class="fab fa-fw fa-product-hunt"></i>
    <span>Produk</span></a>
</li>

<!-- Nav Item - Tables -->
<li class="nav-item <?= ($_GET['halaman'] == 'datapembeli') ? 'active' : ''; ?>">
  <a class="nav-link" href="?halaman=datapembeli">
    <i class="fas fa-fw fa-users"></i>
    <span>Pembeli</span></a>
</li>

<li class="nav-item <?= ($_GET['halaman'] == 'pembelian') ? 'active' : ''; ?>">
  <a class="nav-link" href="?halaman=pembelian">
    <i class="fas fa-fw fa-store"></i>
    <span>Pembelian</span></a>
</li>

<li class="nav-item <?= ($_GET['halaman'] == 'laporan') ? 'active' : ''; ?>">
  <a class="nav-link" href="?halaman=laporan">
    <i class="fas fa-fw fa-file"></i>
    <span>Laporan</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?= ($_GET['halaman'] == 'loginlog') ? 'active' : ''; ?>">
  <a class="nav-link" href="?halaman=loginlog">
    <i class="fas fa-fw fa-clock"></i>
    <span>Login Log</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->