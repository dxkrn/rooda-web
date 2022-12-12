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
    $passPlaceHolder = "";
} else {
    $activeUser = $_SESSION['username'];
    $buttonName = "Log Out";
    $buttonHref = "logout";
    $roleName = $_SESSION['role'];
    $passPlaceHolder = "*****";
}

//get data Pelanggan
$sql = mysqli_query($conn, "SELECT * FROM tb_pelanggan WHERE id_pelanggan='$id_pelanggan'");
$data = mysqli_fetch_array($sql);

$nama_pelanggan = $data['nama'];
$nik = $data['nik'];
$telp = $data['telp'];
$tgl_lahir = $data['tgl_lahir'];
$alamat = $data['alamat'];
$email =  $_SESSION['email'];
if ($data['jenis_kelamin'] == 'L') {
    $jenis_kelamin = 'Laki-laki';
} else if ($data['jenis_kelamin'] == 'P') {
    $jenis_kelamin = 'Perempuan';
}

//ubah data diri
if (isset($_POST['submitEditData'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $telp = $_POST['telp'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $editQuery = "UPDATE tb_pelanggan SET nama='$nama', jenis_kelamin='$jenis_kelamin', telp='$telp', tgl_lahir='$tgl_lahir', alamat='$alamat', nik='$nik' WHERE id_pelanggan='$id_pelanggan'";

    $editData = mysqli_query($conn, $editQuery);
    if ($editData) {
        header('refresh:0; url=dataDiri');
        echo "<script>alert('Yeay, ubah data diri berhasil!')</script>";
    } else {
        echo "<script>alert('Yahh :( ubah data diri gagal!')</script>";
        // header('location:stock.php');
    }
}

//ubah password
if (isset($_POST['submitUbahPassword'])) {
    $username = $activeUser;
    $passwordOld = md5($_POST['password_old']);
    $passwordNew = md5($_POST['password_new']);
    $repasswordNew = md5($_POST['repassword_new']);

    $getDataUser = mysqli_query($conn, "SELECT * FROM users WHERE name='$username' AND password='$passwordOld'");

    if ($getDataUser->num_rows > 0) {
        if ($passwordNew == $repasswordNew) {
            $updatePassword = mysqli_query($conn, "UPDATE users SET password='$passwordNew' WHERE name='$username'");
            if ($updatePassword) {
                header('refresh:0; url=dataDiri');
                echo "<script>alert('Yeay, update password berhasil!')</script>";
            } else {
                header('refresh:0; url=dataDiri');
                echo "<script>alert('Yahh :( update password gagal!')</script>";
            }
        } else {
            header('refresh:0; url=dataDiri');
            echo "<script>alert('Password tidak cocok!')</script>";
        }
    } else {
        header('refresh:0; url=dataDiri');
        echo "<script>alert('Password lama salah!')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Data Diri - Rooda</title>

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
                    <li class="menu-item">
                        <a href="dashboardPelanggan" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-item active">
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
                                        <h3>Data Diri Anda</h3>
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
                            <div class="col-lg-12 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Username</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $activeUser ?></b></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Email</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $email ?></b></p>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <p class="card-title ">Password</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $passPlaceHolder ?></b></p>
                                                    </div>
                                                    <?php
                                                    if ($_SESSION['username'] == "") {
                                                        echo '';
                                                    } else {
                                                        echo '<div class="col-md-8">';
                                                        echo '<a href="#ubahPassword" data-bs-toggle="modal" data-bs-target="#ubahPassword" class="btn btn-primary">Ubah Password</a>';
                                                        echo '</div>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Nama</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $nama_pelanggan ?></b></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p class="card-title ">NIK</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $nik ?></b></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Jenis Kelamin</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $jenis_kelamin ?></b></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Email</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $email ?></b></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Telepon</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $telp ?></b></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Tanggal Lahir</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= tanggal($tgl_lahir) ?></b></p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p class="card-title ">Alamat</p>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p class="card-title ">: <b><?= $alamat ?></b></p>
                                                    </div>
                                                    <?php
                                                    if ($_SESSION['username'] == "") {
                                                        echo '';
                                                    } else {
                                                        echo '<div class="col-md-8">';
                                                        echo '<a href="#editModal" data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary">Ubah Data Diri</a>';
                                                        echo '</div>';
                                                    }
                                                    ?>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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


    <!-- Modal edit data diri -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST">
                <input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Edit Data Diri</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameLarge" class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $nama_pelanggan ?>" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameLarge" class="form-label">NIK</label>
                                <input type="number" name="nik" class="form-control" value="<?= $nik ?>" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-0">
                                <label for="emailLarge" class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="jenis_kelamin" aria-label="Default select example">
                                    <option selected value="<?= substr($jenis_kelamin, 0, 1) ?>"><?= $jenis_kelamin ?></option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameLarge" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= $email ?>" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameLarge" class="form-label">Telepon</label>
                                <input type="number" name="telp" class="form-control" value="<?= $telp ?>" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="html5-date-input" class="col-md-2 col-form-label">Tanggal Lahir</label>
                                <input class="form-control" type="date" value="<?= $tgl_lahir ?>" id="tgl_lahir" name="tgl_lahir" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameLarge" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="3" required><?= $alamat ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" name="submitEditData" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal ubah password -->
    <div class="modal fade" id="ubahPassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <form method="POST">
                <input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel3">Ubah Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameLarge" class="form-label">Password lama</label>
                                <input type="password" name="password_old" class="form-control" placeholder="Ketikkan Password lama Anda" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameLarge" class="form-label">Password baru</label>
                                <input type="password" name="password_new" class="form-control" placeholder="Ketikkan Password baru" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameLarge" class="form-label">Re-Password baru</label>
                                <input type="password" name="repassword_new" class="form-control" placeholder="Ketikkan ulang Password baru" required />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" name="submitUbahPassword" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


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