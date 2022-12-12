<?php

include 'config.php';
include 'functions.php';

error_reporting(0);

session_start();


$activeUser = $_SESSION['username'];
$id_pelanggan = getIDPelanggan($conn, $activeUser);
if ($activeUser == "") {
    $activeUser = "Not Loged in";
    $buttonName = "Login Now";
    $buttonHref = "login";
    $roleName = "";
    $logoUrl = "index";
} else {
    $activeUser = $_SESSION['username'];;
    $buttonName = "Log Out";
    $buttonHref = "logout";
    $roleName = $_SESSION['role'];
    $logoUrl = "dashboardPelanggan";
}

//Inisialisasi nilai POST untuk filter
if ($_POST['filter_merk'] == '') {
    $filterMerk = '';
    $_POST['filter_merk'] = $filterMerk;
    $_POST['filter_merk_placeholder'] = "Semua";
} else {
    $_POST['filter_merk_placeholder'] = $_POST['filter_merk'];
}

if ($_POST['filter_jenis'] == '') {
    $filterJenis = '';
    $_POST['filter_jenis'] = $filterJenis;
    $_POST['filter_jenis_placeholder'] = "Semua";
} else {
    $_POST['filter_jenis_placeholder'] = $_POST['filter_jenis'];
}

if ($_POST['sort_harga'] == '') {
    $sortHarga = 'ASC';
    $_POST['sort_harga'] = $sortHarga;
    $_POST['sort_harga_placeholder'] = "Termurah";
} else if ($_POST['sort_harga'] == 'ASC') {
    $sortHarga = 'ASC';
    $_POST['sort_harga'] = $sortHarga;
    $_POST['sort_harga_placeholder'] = "Termurah";
} else if ($_POST['sort_harga'] == 'DESC') {
    $sortHarga = 'DESC';
    $_POST['sort_harga'] = $sortHarga;
    $_POST['sort_harga_placeholder'] = "Termahal";
}


//Inisialisasi nilai POST untuk searching
if ($_POST['search_value'] == '') {
    $searchValue = '';
    $placeHolder = "Coba 'Vario'";
} else {
    $searchValue = $_POST['search_value'];
    $placeHolder = '';
}

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard Pelanggan - Rooda</title>

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
                    <a href="<?= $logoUrl ?>" class="app-brand-link">
                        <img src="assets/img/logo/logo_rooda.png" width="100">
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- NOTE : Dashboard -->
                    <li class="menu-item active">
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
                    <li class="menu-item">
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
                                        <h3>Motor Anda</h3>
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

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row g-2">

                        </div>


                        <div class="card mb-4">
                            <div class="d-flex align-items-end row">
                                <div class="card-body">
                                    <div class="row g-2 d-flex justify-content-between">
                                        <div class="col-md-7">
                                            <form method="POST">
                                                <div class="input-group">
                                                    <select class="form-select" id="" aria-label="Example select with button addon" name="filter_merk">
                                                        <option selected value="<?= $_POST['filter_merk'] ?>"><?= strtoupper(preg_replace("/_/", " ",  $_POST['filter_merk_placeholder'])) ?></option>
                                                        <option value="">Semua</option>
                                                        <option value="honda">Honda</option>
                                                        <option value="vespa">Vespa</option>
                                                        <option value="yamaha">Yamaha</option>
                                                    </select>
                                                    <select class="form-select" id="inputGroupSelect04" name="filter_jenis">
                                                        <option selected value="<?= $_POST['filter_jenis'] ?>"><?= strtoupper(preg_replace("/_/", " ",  $_POST['filter_jenis_placeholder'])) ?></option>
                                                        <option value="">Semua</option>
                                                        <option value="matic">Matic</option>
                                                        <option value="cub">Cub</option>
                                                        <option value="sport">Sport</option>
                                                        <option value="naked">Naked</option>
                                                        <option value="offroad">Offroad</option>

                                                    </select>
                                                    <select class="form-select" id="inputGroupSelect04" name="sort_harga">
                                                        <option selected value="<?= $_POST['sort_harga'] ?>"><?= strtoupper($_POST['sort_harga_placeholder']) ?></option>
                                                        <option value="ASC">Termurah</option>
                                                        <option value="DESC">Termahal</option>
                                                    </select>
                                                    <button class="btn btn-primary" type="submit" name="submitFilter">Filter</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- search input -->
                                        <div class="col-md-4">
                                            <form method="POST">
                                                <div class="input-group">
                                                    <input type="text" name="search_value" class="form-control" placeholder="<?= $placeHolder ?>" value="<?= $searchValue ?>" aria-describedby="button-addon2" />
                                                    <button class="btn btn-primary" type="submit" id="button-addon2" name="submitSearch">Search</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Katalog -->
                        <!-- <div class="row"> -->
                        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
                            <?php

                            if (isset($_POST['submitFilter'])) {
                                $filterMerk = $_POST['filter_merk'];
                                $filterJenis = $_POST['filter_jenis'];
                                $sortHarga = $_POST['sort_harga'];
                                header('refresh:0; url=stockMotor');
                            }

                            if (isset($_POST['submitSearch'])) {
                                $searchValue = $_POST['search_value'];
                                header('refresh:0; url=stockMotor');
                            }

                            $ambil_data_stock = mysqli_query(
                                $conn,
                                "SELECT tr.id_pelanggan, mt.id_motor, mt.img_src, mt.nama, mr.nama_merk, jm.nama_jenis_motor, mt.harga, mt.stock, mt.persentase_laba, mt.persentase_sparepart, mt.description,
                                        sp.tipe_mesin, sp.volume_silinder, sp.tipe_transmisi, sp.kapasitas_bbm, mt.img_src
                                        FROM tb_motor mt
                                        JOIN tb_merk mr
                                        USING(id_merk)
                                        JOIN tb_jenis_motor jm
                                        USING(id_jenis_motor)
                                        JOIN tb_spesifikasi sp
                                        USING(id_motor)
                                        JOIN tb_detail_transaksi dt
                                        USING(id_motor)
                                        JOIN tb_transaksi tr
                                        USING(id_transaksi)
                                        WHERE id_pelanggan = '$id_pelanggan'
                                            AND nama_merk LIKE '%$filterMerk%'
                                                AND nama_jenis_motor LIKE '%$filterJenis%'
                                            HAVING nama LIKE '%$searchValue%'
                                                OR nama_merk LIKE '%$searchValue%'
                                                OR nama_jenis_motor LIKE '%$searchValue%'
                                            ORDER BY harga $sortHarga
                                            "
                            );

                            while ($data = mysqli_fetch_array($ambil_data_stock)) {
                                $id_motor = $data['id_motor'];
                                $img_src = $data['img_src'];
                                $nama = $data['nama'];
                                $nama_merk = $data['nama_merk'];
                                $nama_jenis_motor = $data['nama_jenis_motor'];
                                $harga = $data['harga'];
                                $tipe_mesin = $data['tipe_mesin'];
                                $volume_silinder = $data['volume_silinder'];
                                $tipe_transmisi = $data['tipe_transmisi'];
                                $kapasitas_bbm = $data['kapasitas_bbm'];
                                $persentase_laba = $data['persentase_laba'];
                                $description = $data['description'];
                                $img_src = $data['img_src'];
                            ?>
                                <div class="col">
                                    <div class="card h-100 text-center">
                                        <div class="card-body">
                                            <img class="card-img-tops mb-2" src="<?= $img_src ?>" alt="Motor <?= $nama ?>" width="90%" />
                                            <h4 class="card-title "><?= $nama ?></h4>
                                            <h5 class="card-title " style="color: #5F61E6;"><?= rupiah($harga) ?></h5>
                                            <p class="card-text text-truncate">
                                                <?= $description ?>
                                            </p>
                                            <br>
                                            <br>
                                            <div class="position-absolute bottom-0 start-50 translate-middle">
                                                <button type="button" name="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal<?= $id_motor; ?>">Spesifikasi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="detailModal<?= $id_motor; ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="modalToggleLabel">Spesifikasi <?= $nama ?></h3>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center mb-4"><img src="<?= $img_src ?>" width="80%" alt="<?= $img_src ?>"></div>
                                                <div class="text-center">
                                                    <p><?= $description ?></p>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Merk</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $nama_merk ?></b></p>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Nama</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $nama ?></b></p>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Jenis</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $nama_jenis_motor ?></b></p>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Tipe Mesin</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $tipe_mesin ?></b></p>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Volume Silinder</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $volume_silinder ?> CC</b></p>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Tipe Transmisis</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $tipe_transmisi ?></b></p>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Kapasitas BBM</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $kapasitas_bbm ?> Liter</b></p>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Sisa Stock</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $stock ?> unit</b></p>
                                                    </div>
                                                </div>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Harga</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= rupiah($harga) ?></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>

                        </div>
                        <!-- </div> -->



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