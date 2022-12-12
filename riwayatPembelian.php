<?php

include 'config.php';
include 'functions.php';

error_reporting(0);

session_start();


$activeUser = $_SESSION['username'];
if ($activeUser == "") {
    $activeUser = "Not Loged in";
    $buttonName = "Login Now";
    $buttonHref = "login";
    $roleName = "";
} else {
    $activeUser = $_SESSION['username'];;
    $buttonName = "Log Out";
    $buttonHref = "logout";
    $roleName = $_SESSION['role'];
}

//getID pelanggan
$id_pelanggan = getIDPelanggan($conn, $activeUser);

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title> Riwayat Pembelian - Rooda</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/icon_favicon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

    <script src="assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->


            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="dashboardPelanggan" class="app-brand-link">
                        <img src="assets/img/logo/logo_rooda.png" width="100">
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- NOTE : Dashboard -->
                    <li class="menu-item ">
                        <a href="dashboardPelanggan" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="dataDiri" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div data-i18n="Analytics">Data Diri</div>
                        </a>
                    </li>
                    <li class="menu-item active">
                        <a href="riwayatPembelian" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-detail"></i>
                            <div data-i18n="Analytics">Riwayat Pembelian</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="riwayatService" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-detail"></i>
                            <div data-i18n="Analytics">Riwayat Service</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="katalogMotor" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-box"></i>
                            <div data-i18n="Analytics">Katalog Motor</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="katalogSparepart" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-package"></i>
                            <div data-i18n="Analytics">Katalog Sparepart</div>
                        </a>
                    </li>
                </ul>
                <footer class="content-footer footer">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            Made with ❤️ by
                            <a href="https://github.com/dxkrnn" target="_blank" class="footer-link fw-bolder">Dxkrn</a>
                        </div>
                    </div>
                </footer>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav flex-row align-items-center">
                            <table>
                                <tr>
                                    <td>
                                        <h3>Riwayat Pembelian</h3>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <ul class="navbar-nav flex-row align-items-center ms-auto">

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="assets/img/avatars/avatar.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="assets/img/avatars/avatar.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block"><?= $activeUser ?></span>
                                                    <small class="text-muted"><?= $roleName ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= $buttonHref ?>.php">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle"><?= $buttonName ?></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl container-p-y">
                        <div class="row">
                            <!-- <div class="col-lg-12 mb-4 order-0"> -->

                            <!-- Hoverable Table rows -->


                            <!-- responsive table -->

                            <div class="card">
                                <h3 class="card-header">
                                    <div class="row g-2 d-flex justify-content-between">
                                    </div>
                                </h3>
                                <div class="table-responsive text-nowrap">
                                    <table id="" class="table table-hover">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th></th>
                                                <th>ID</th>
                                                <th>Tanggal</th>
                                                <th>Pelanggan</th>
                                                <th>Karyawan</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (isset($_POST['submitSort'])) {
                                                $sortBy = $_POST['sort_by'];
                                                $sortType = $_POST['sort_type'];
                                                $limitValue = $_POST['limit_value'];
                                                $selectedLimit = $_POST['limit_value'];
                                                header('refresh:0; url=transaksiOffline');
                                            }

                                            if (isset($_POST['submitSearch'])) {
                                                $searchValue = $_POST['search_value'];
                                                header('refresh:0; url=transaksiOffline');
                                            }


                                            $ambil_data = mysqli_query(
                                                $conn,
                                                "SELECT tr.id_transaksi, tr.tgl_transaksi,
                                                    pg.nama AS nama_pelanggan, pg.nik, pg.telp AS telp_pelanggan, pg.alamat,
                                                    kr.nama AS nama_karyawan, kr.telp AS telp_karyawan
                                                    FROM tb_transaksi tr
                                                    JOIN tb_pelanggan pg
                                                    USING(id_pelanggan)
                                                    JOIN tb_karyawan kr
                                                    USING(id_karyawan)
                                                    WHERE pg.id_pelanggan = '$id_pelanggan'
                                                    "
                                            );

                                            while ($data = mysqli_fetch_array($ambil_data)) {
                                                $id_transaksi = $data['id_transaksi'];
                                                $tgl_transaksi = $data['tgl_transaksi'];
                                                $nama_pelanggan = $data['nama_pelanggan'];
                                                $nik = $data['nik'];
                                                $telp = $data['telp_pelanggan'];
                                                $alamat = $data['alamat'];
                                                $nama_karyawan = $data['nama_karyawan'];
                                                $telp_karyawan = $data['telp_karyawan'];
                                            ?>

                                                <tr>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">

                                                                <form method="POST" action="detailTransaksi">
                                                                    <input type="hidden" name="id_transaksi" value="<?= $id_transaksi; ?>">
                                                                    <input type="hidden" name="tgl_transaksi" value="<?= $tgl_transaksi; ?>">
                                                                    <input type="hidden" name="nama_pelanggan" value="<?= $nama_pelanggan; ?>">
                                                                    <input type="hidden" name="nik" value="<?= $nik; ?>">
                                                                    <input type="hidden" name="alamat_pelanggan" value="<?= $alamat; ?>">
                                                                    <input type="hidden" name="telp_pelanggan" value="<?= $telp; ?>">
                                                                    <input type="hidden" name="nama_karyawan" value="<?= $nama_karyawan; ?>">
                                                                    <input type="hidden" name="telp_karyawan" value="<?= $telp_karyawan; ?>">
                                                                    <button type="submit" name="submitDetailPerbaikan" class="dropdown-item"><i class="bx bx-detail me-1"></i> Lihat Detail</button>
                                                                </form>


                                                                <input type="hidden" name="id_hapus" value="<?= $id_transaksi; ?>">


                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td><b><?= $id_transaksi ?></b></td>
                                                    <td><?= tanggal($tgl_transaksi) ?></td>
                                                    <td><?= $nama_pelanggan ?></td>
                                                    <td><?= $nama_karyawan ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- responsive table -->


                        </div>
                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>