<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <?php
    $tglawal = date('Y-m-01 01:00:00');
    $tglakhir = date('Y-m-01 01:00:00', strtotime('+30 days'));
    // echo $tglakhir;
    $query = mysqli_query($conn, "SELECT * FROM pembelian WHERE tgl_pembelian BETWEEN '$tglawal' AND '$tglakhir'");
    $jmlbeli = mysqli_num_rows($query);
    ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Pembelian (Bulanan)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlbeli; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Tahunan) Card Example -->
    <?php
    $thawal = date('Y-01-01 01:00:00');
    $thakhir = date('Y-01-01 01:00:00', strtotime('+1 year'));
    // echo $thawal;
    // echo $thakhir;
    $query = mysqli_query($conn, "SELECT * FROM pembelian WHERE tgl_pembelian BETWEEN '$thawal' AND '$thakhir'");
    $jmlbeli = mysqli_num_rows($query);
    ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Pembelian (Tahunan)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlbeli; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Earnings (Annual)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase">
                            Pembelian yang belum diproses</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlbeli; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Pending Requests Card Example -->
    <?php
    // sudah mengirim pembayaran
    $query = mysqli_query($conn, "SELECT * FROM pembeli");
    $jmlpembeli = mysqli_num_rows($query);
    ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
        <a href="?halaman=datapembeli">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Jumlah Pembeli</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlpembeli; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </a>
        </div>
    </div>

    <?php
    // sudah mengirim pembayaran
    $query = mysqli_query($conn, "SELECT * FROM pembelian WHERE status_pembelian = '1'");
    $jmlpending = mysqli_num_rows($query);
    ?>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
        <a href="?halaman=pembelian">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Transaksi Yang Belum Diproses</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jmlpending; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </a>
        </div>
    </div>
    <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Requests</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>

</div>