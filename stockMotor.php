<?php
include 'config.php';
include 'functions.php';

error_reporting(0);

session_start();
if (!isset(($_SESSION['username']))) {
  header("Location:index");
  exit();
}
$activeUser = $_SESSION['username'];

//Inisialisasi nilai POST untuk sorting
if ($_POST['sort_by'] == '') {
  $sortBy = 'id_motor';
  $sortType = 'ASC';
  $_POST['sort_by'] = $sortBy;
  $_POST['sort_type'] = $sortType;
}

//Inisialisasi nilai Limit
if ($_POST['limit_value'] == '') {
  $limitValue = 100;
  $_POST['limit_value'] = $limitValue;
  $selectedLimit = 'All';
}

//Inisialisasi nilai POST untuk searching
if ($_POST['search_value'] == '') {
  $searchValue = '';
  $placeHolder = 'Search anything..';
} else {
  $searchValue = $_POST['search_value'];
  $placeHolder = '';
}

//Menambah Motor Baru
if (isset($_POST['submitTambahMotor'])) {
  $id_motor = getLastID($conn, 'tb_motor', 'id_motor', 'MT');
  $nama = $_POST['nama'];
  $id_merk = $_POST['id_merk'];
  $id_jenis_motor = $_POST['id_jenis_motor'];
  $harga = $_POST['harga'];
  $persentase_laba = $_POST['persentase_laba'];
  $persentase_sparepart = $_POST['persentase_sparepart'];
  $stock = $_POST['stock'];
  $description = $_POST['description'];
  $img_src = '';
  $tipe_mesin = $_POST['tipe_mesin'];
  $volume_silinder = $_POST['volume_silinder'];
  $tipe_transmisi = $_POST['tipe_transmisi'];
  $kapasitas_bbm = $_POST['kapasitas_bbm'];

  //Menangani file foto
  $ekstensi =  array('png');
  $filename = $_FILES['img_src']['name'];
  $ukuran = $_FILES['img_src']['size'];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);

  //query-query yang akan digunakan
  $insertMotorQuery = "INSERT INTO tb_motor (id_motor, id_jenis_motor, id_merk, nama, harga, persentase_laba, persentase_sparepart, stock, description, img_src) 
                  VALUES ('$id_motor', '$id_jenis_motor' , '$id_merk', '$nama','$harga', '$persentase_laba', '$persentase_sparepart', '$stock', '$description', 'assets/gambar/motor/$filename')";

  $insertSpesifikasiQuery = "INSERT INTO tb_spesifikasi (id_motor, tipe_mesin, volume_silinder, tipe_transmisi, kapasitas_bbm) 
                  VALUES ('$id_motor', '$tipe_mesin', '$volume_silinder', '$tipe_transmisi', '$kapasitas_bbm')";

  //menangani data dan input ke db
  if (!in_array($ext, $ekstensi)) {
    echo "<script>alert('Ekstensi File tidak sesuai')</script>";
  } else {
    $addtotableMotor = mysqli_query($conn, $insertMotorQuery);
    if ($addtotableMotor) {
      move_uploaded_file($_FILES['img_src']['tmp_name'], 'assets/gambar/motor/' . $filename);
      $addtotableSpesifikasi = mysqli_query($conn, $insertSpesifikasiQuery);
      if ($addtotableSpesifikasi) {
        header('refresh:0; url=stockMotor');
        echo "<script>alert('Yeay, Tambah Motor berhasil!')</script>";
      }
    } else {
      echo "<script>alert('Yahh :( Tambah Motor gagal!')</script>";
    }
  }
}

// Edit Motor
if (isset($_POST['submitEditMotor'])) {
  $id_motor = $_POST['id_motor'];
  $nama = $_POST['nama'];
  $id_merk = $_POST['id_merk'];
  $id_jenis_motor = $_POST['id_jenis_motor'];
  $harga = $_POST['harga'];
  $persentase_laba = $_POST['persentase_laba'];
  $persentase_sparepart = $_POST['persentase_sparepart'];
  $stock = $_POST['stock'];
  $description = $_POST['description'];
  $img_src = '';
  $tipe_mesin = $_POST['tipe_mesin'];
  $volume_silinder = $_POST['volume_silinder'];
  $tipe_transmisi = $_POST['tipe_transmisi'];
  $kapasitas_bbm = $_POST['kapasitas_bbm'];

  //Menangani file foto
  $ekstensi =  array('png');
  $filename = $_FILES['img_src']['name'];
  $ukuran = $_FILES['img_src']['size'];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);


  $editMotorQueryWithImage = "UPDATE tb_motor SET nama='$nama', harga='$harga', persentase_laba='$persentase_laba', persentase_sparepart='$persentase_sparepart', stock='$stock', description='$description', img_src='assets/gambar/motor/$filename' WHERE id_motor='$id_motor'";
  $editMotorQueryWithoutImage = "UPDATE tb_motor SET nama='$nama', harga='$harga', persentase_laba='$persentase_laba', persentase_sparepart='$persentase_sparepart', stock='$stock', description='$description' WHERE id_motor='$id_motor'";

  $editSpesifikasiQuery = "UPDATE tb_spesifikasi SET tipe_mesin='$tipe_mesin', volume_silinder='$volume_silinder', tipe_transmisi='$tipe_transmisi', kapasitas_bbm='$kapasitas_bbm' WHERE id_motor='$id_motor'";

  if ($filename == "") {
    $editMotor = mysqli_query($conn, $editMotorQueryWithoutImage);
    if ($editMotor) {
      $editSpesifikasi = mysqli_query($conn, $editSpesifikasiQuery);
      if ($editSpesifikasi) {
        header('refresh:0; url=stockMotor');
        echo "<script>alert('Yeay, Edit Motor berhasil!')</script>";
      }
    } else {
      echo "<script>alert('Yahh :( Edit Motor gagal!')</script>";
      // header('location:stockMotor');
    }
  } else {
    if (!in_array($ext, $ekstensi)) {
      echo "<script>alert('Ekstensi File tidak sesuai')</script>";
    } else {
      $editMotor = mysqli_query($conn, $editMotorQueryWithImage);
      if ($editMotor) {
        move_uploaded_file($_FILES['img_src']['tmp_name'], 'assets/gambar/motor/' . $filename);
        $editSpesifikasi = mysqli_query($conn, $editSpesifikasiQuery);
        if ($editSpesifikasi) {
          header('refresh:0; url=stockMotor');
          echo "<script>alert('Yeay, Edit Motor berhasil!')</script>";
        }
      } else {
        echo "<script>alert('Yahh :( Edit Motor gagal!')</script>";
      }
    }
  }
}


//Hapus Persediaan Barang
if (isset($_POST['submitHapus'])) {
  $id_motor = $_POST['id_motor'];

  $delTableSpesifikasi =  mysqli_query($conn, "DELETE FROM tb_spesifikasi WHERE id_motor='$id_motor'");

  if ($delTableSpesifikasi) {
    $delTableMotor =  mysqli_query($conn, "DELETE FROM tb_motor WHERE id_motor='$id_motor'");
    if ($delTableSpesifikasi) {
      echo "<script>alert('Yeay, Hapus Motor berhasil!')</script>";
    }
  } else {
    echo "<script>alert('Yahh :( Hapus Motor gagal!')</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Motor - Rooda</title>

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
          <a href="dashboard" class="app-brand-link">
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
            <a href="dashboard" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-alt"></i>
              <div data-i18n="Analytics">Dashboard</div>
            </a>
          </li>

          <!-- NOTE : Persediaan Motor -->
          <li class="menu-item active open">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-package"></i>
              <div data-i18n="Layouts">Persediaan Motor</div>
            </a>

            <ul class="menu-sub">
              <li class="menu-item active">
                <a href="stockMotor" class="menu-link">
                  <div data-i18n="Without navbar">Stock Motor</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="motorMasuk" class="menu-link">
                  <div data-i18n="Without navbar">Motor Masuk</div>
                </a>
              </li>

            </ul>
          </li>

          <!-- NOTE : Persediaan Sparepart -->
          <li class="menu-item">
            <a href="stockSparepart" class="menu-link">
              <i class="menu-icon tf-icons bx bx-box"></i>
              <div data-i18n="Layouts">Persediaan Part</div>
            </a>
          </li>

          <!-- NOTE : Transaksi -->
          <li class="menu-item">
            <a href="../transaksi/detail.php" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
              <div data-i18n="Analytics">Transaksi</div>
            </a>

            <ul class="menu-sub">
              <li class="menu-item">
                <a href="transaksiOffline" class="menu-link">
                  <div data-i18n="Without navbar">Offline</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="transaksiOnline" class="menu-link">
                  <div data-i18n="Without navbar">Online</div>
                </a>
              </li>
            </ul>
          </li>

          <!-- NOTE : Perbaikan -->
          <li class="menu-item">
            <a href="perbaikan" class="menu-link">
              <i class="menu-icon tf-icons bx bx-analyse"></i>
              <div data-i18n="Analytics">Perbaikan</div>
            </a>
          </li>

          <!-- NOTE : Karyawan -->
          <!-- NOTE : Karyawan -->
          <li class="menu-item">
            <a href="" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-group"></i>
              <div data-i18n="Analytics">Karyawan</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item">
                <a href="karyawan" class="menu-link">
                  <div data-i18n="Analytics">Daftar Karyawan</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="gajiKaryawan" class="menu-link">
                  <div data-i18n="Without navbar">Gaji Karyawan</div>
                </a>
              </li>
            </ul>
          </li>

          <!-- NOTE : Pelanggan -->
          <li class="menu-item">
            <a href="pelanggan" class="menu-link">
              <i class="menu-icon tf-icons bx bx-group"></i>
              <div data-i18n="Analytics">Pelanggan</div>
            </a>
          </li>

          <!-- NOTE : Supplier -->
          <li class="menu-item">
            <a href="supplier" class="menu-link">
              <i class="menu-icon tf-icons bx bx-archive-in"></i>
              <div data-i18n="Analytics">Supplier</div>
            </a>
          </li>

          <!-- NOTE : Call Center -->
          <li class="menu-item">
            <a href="callCenter" class="menu-link">
              <i class="menu-icon tf-icons bx bx-phone"></i>
              <div data-i18n="Analytics">Call Center</div>
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

        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav flex-row align-items-center">
              <table>
                <tr>
                  <td>
                    <p></p>
                  </td>
                </tr>
                <tr>
                  <td>
                    <h3>Stock Motor</h3>
                  </td>
                </tr>


              </table>

            </div>
            <!-- /Search -->

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
                          <small class="text-muted">Admin</small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="logout.php">
                      <i class="bx bx-power-off me-2"></i>
                      <span class="align-middle">Log Out</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/ User -->
            </ul>
          </div>
        </nav>

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl container-p-y">
            <div class="row">

              <div class="card">
                <h3 class="card-header">
                  <div class="row g-2 d-flex justify-content-between">
                    <!-- sort input -->
                    <div class="col-md-7">
                      <form method="POST">
                        <div class="input-group">
                          <select class="form-select" id="" aria-label="Example select with button addon" name="sort_by">
                            <option selected value="<?= $_POST['sort_by'] ?>"><?= strtoupper(preg_replace("/_/", " ",  $_POST['sort_by'])) ?></option>
                            <option value="id_motor">ID Motor</option>
                            <option value="nama">Nama</option>
                            <option value="nama_merk">Merk</option>
                            <option value="nama_jenis_motor">Jenis</option>
                            <option value="harga">Harga</option>
                            <option value="stock">Stock</option>
                            <option value="tipe_mesin">Tipe Mesin</option>
                            <option value="volume_silinder">Volume Silinder</option>
                            <option value="tipe_transmisi">Transmisi</option>
                            <option value="kapasitas_bbm">Kapasitas BBM</option>
                          </select>
                          <select class="form-select" id="inputGroupSelect04" name="sort_type">
                            <option selected value="<?= $_POST['sort_type'] ?>"><?= $_POST['sort_type'] ?>ENDING</option>
                            <option value="ASC">Ascending</option>
                            <option value="DESC">Descending</option>
                          </select>
                          <select class="form-select" id="inputGroupSelect04" name="limit_value">
                            <option selected value="<?= $_POST['limit_value'] ?>"><?= $_POST['limit_value'] ?> items</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                          </select>
                          <button class="btn btn-primary" type="submit" name="submitSort">Sort</button>
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
                </h3>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr class="text-nowrap">
                        <th></th>
                        <th>ID Motor</th>
                        <!-- <th>Gambar</th> -->
                        <th>Nama</th>
                        <th>Merk</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Stock</th>
                        <th>Tipe Mesin</th>
                        <th>Volume Silinder</th>
                        <th>Transmisi</th>
                        <th>Kapasitas BBM</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php

                      if (isset($_POST['submitSort'])) {
                        $sortBy = $_POST['sort_by'];
                        $sortType = $_POST['sort_type'];
                        $limitValue = $_POST['limit_value'];
                        $selectedLimit = $_POST['limit_value'];
                        header('refresh:0; url=stockMotor');
                      }

                      if (isset($_POST['submitSearch'])) {
                        $searchValue = $_POST['search_value'];
                        header('refresh:0; url=stockMotor');
                      }

                      $ambil_data_stock = mysqli_query(
                        $conn,
                        "SELECT mt.id_motor, mt.img_src, mt.nama, mr.nama_merk, jm.nama_jenis_motor, mt.harga, mt.stock, mt.persentase_laba, mt.persentase_sparepart, mt.description,
                          sp.tipe_mesin, sp.volume_silinder, sp.tipe_transmisi, sp.kapasitas_bbm
                          FROM tb_motor mt
                          JOIN tb_merk mr
                          USING(id_merk)
                          JOIN tb_jenis_motor jm
                          USING(id_jenis_motor)
                          JOIN tb_spesifikasi sp
                          USING(id_motor)
                          WHERE nama LIKE '%$searchValue%' OR id_motor LIKE '%$searchValue%'
                            OR nama_merk LIKE '%$searchValue%' OR nama_jenis_motor LIKE '%$searchValue%'
                            OR harga LIKE '%$searchValue%' OR stock LIKE '%$searchValue%'
                            OR tipe_mesin LIKE '%$searchValue%' OR volume_silinder LIKE '%$searchValue%'
                            OR tipe_transmisi LIKE '%$searchValue%' OR kapasitas_bbm LIKE '%$searchValue%'
                          ORDER BY $sortBy $sortType
                          LIMIT $limitValue
                          "
                      );

                      while ($data = mysqli_fetch_array($ambil_data_stock)) {
                        $id_motor = $data['id_motor'];
                        $img_src = $data['img_src'];
                        $nama = $data['nama'];
                        $nama_merk = $data['nama_merk'];
                        $nama_jenis_motor = $data['nama_jenis_motor'];
                        $harga = $data['harga'];
                        $stock = $data['stock'];
                        $tipe_mesin = $data['tipe_mesin'];
                        $volume_silinder = $data['volume_silinder'];
                        $tipe_transmisi = $data['tipe_transmisi'];
                        $kapasitas_bbm = $data['kapasitas_bbm'];
                        $persentase_laba = $data['persentase_laba'];
                        $persentase_sparepart = $data['persentase_sparepart'];
                        $description = $data['description'];
                      ?>

                        <tr>
                          <td>
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">

                                <a class="dropdown-item" href="#gambarModal<?= $id_motor; ?>" data-bs-toggle="modal" data-bs-target="#gambarModal<?= $id_motor; ?>"><i class="bx bx-image me-1"></i> Lihat</a>
                                <a class="dropdown-item" href="#editModal<?= $id_motor; ?>" data-bs-toggle="modal" data-bs-target="#editModal<?= $id_motor; ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                <input type="hidden" name="id_motor_to_hapus" value="<?= $id_motor; ?>">
                                <a class="dropdown-item" href="#hapusModal<?= $id_motor; ?>" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $id_motor; ?>"><i class="bx bx-trash me-1"></i> Delete</a>

                              </div>
                            </div>
                          </td>
                          <td><b><?= $id_motor ?></b></td>
                          <td><?= $nama ?></td>
                          <td><?= $nama_merk ?></td>
                          <td><?= $nama_jenis_motor ?></td>
                          <td><?= rupiah($harga) ?></td>
                          <td><?= $stock ?></td>
                          <td><?= $tipe_mesin ?></td>
                          <td><?= $volume_silinder ?></td>
                          <td><?= $tipe_transmisi ?></td>
                          <td><?= $kapasitas_bbm ?></td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $id_motor; ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <form method="POST" enctype="multipart/form-data">
                              <input type="hidden" name="id_motor" value="<?= $id_motor; ?>">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel3">Edit Motor</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Nama Motor</label>
                                      <input type="text" name="nama" class="form-control" placeholder="<?= $nama ?>" value="<?= $nama ?>" />
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Harga</label>
                                      <input type="number" name="harga" class="form-control" placeholder="<?= $harga ?>" value="<?= $harga ?>" />
                                    </div>
                                  </div>
                                  <div class="row g-2">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Persentase Laba [0 - 100]</label>
                                      <input type="number" name="persentase_laba" class="form-control" placeholder="<?= $persentase_laba ?>" value="<?= $persentase_laba ?>" />
                                    </div>
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Persentase Sparepart [100 - 500]</label>
                                      <input type="number" name="persentase_sparepart" class="form-control" placeholder="<?= $persentase_sparepart ?>" value="<?= $persentase_sparepart ?>" />
                                    </div>
                                  </div>
                                  <div class="row g-2">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Stock</label>
                                      <input type="number" name="stock" class="form-control" placeholder="<?= $stock ?>" value="<?= $stock ?>" />
                                    </div>
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Foto <b>[ .png ]</b></label>
                                      <input type="file" name="img_src" class="form-control" />
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Deskripsi</label>
                                      <textarea class="form-control" name="description" rows="3" placeholder="<?= $description ?>"><?= $description ?></textarea>
                                    </div>
                                  </div>
                                  <div class="row g-2">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Tipe Mesin</label>
                                      <input type="text" name="tipe_mesin" class="form-control" placeholder="<?= $tipe_mesin ?>" value="<?= $tipe_mesin ?>" />
                                    </div>
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Tipe Transmisi</label>
                                      <input type="text" name="tipe_transmisi" class="form-control" placeholder="<?= $tipe_transmisi ?>" value="<?= $tipe_transmisi ?>" />
                                    </div>
                                  </div>
                                  <div class="row g-2">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Volume Silinder</label>
                                      <input type="text" name="volume_silinder" class="form-control" placeholder="<?= $volume_silinder ?>" value="<?= $volume_silinder ?>" />
                                    </div>
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Kapasitas BBM</label>
                                      <input type="number" name="kapasitas_bbm" class="form-control" placeholder="<?= $kapasitas_bbm ?>" value="<?= $kapasitas_bbm ?>" />
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Batal
                                  </button>
                                  <button type="submit" name="submitEditMotor" class="btn btn-primary">Simpan</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal<?= $id_motor; ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h3 class="modal-title" id="modalToggleLabel">Hapus Motor</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>

                              <form method="POST">
                                <div class="modal-body">
                                  <input type="hidden" name="id_motor" value="<?= $id_motor ?>">
                                  <p>Yakin hapus <b><?= $nama; ?></b> dengan ID <b><?= $id_motor ?>?</b></p>
                                </div>
                                <div class="modal-footer">
                                  <button class="btn btn-primary d-grid w-100" type="submit" name="submitHapus">Hapus</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                        <!-- Modal Gambar -->
                        <div class="modal fade" id="gambarModal<?= $id_motor; ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h3 class="modal-title" id="modalToggleLabel">Gambar <?= $nama ?></h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="text-center"><img src="<?= $img_src ?>" width="500" alt="<?= $img_src ?>"></div>
                              </div>
                            </div>
                          </div>
                        </div>

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

  <!-- NOTE : BUTTON ADD -->
  <div class="add">
    <!-- <a href="#tambahModal" data-bs-toggle="modal" data-bs-target="#tambahModal">Delete</a> -->

    <a href="#tambahModal" data-bs-toggle="modal" data-bs-target="#tambahModal" type="button" class="btn btn-primary btn-add"> <span class="tf-icons bx bx-plus"></span> Tambah
    </a>
  </div>

  <!-- Modal Tambah -->

  <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel3">Tambah Motor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Nama Motor</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Motor" required />
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-0">
                <label for="emailLarge" class="form-label">Merk Motor</label>
                <select class="form-select" name="id_merk" aria-label="Default select example">
                  <option selected>Pilih Merk</option>
                  <option value="MR1">Vespa</option>
                  <option value="MR2">Yamaha</option>
                  <option value="MR3">Honda</option>
                </select>
              </div>
              <div class="col mb-0">
                <label for="dobLarge" class="form-label">Jenis Motor</label>
                <select class="form-select" name="id_jenis_motor" aria-label="Default select example">
                  <option selected>Pilih Jenis</option>
                  <option value="JM1">Matic</option>
                  <option value="JM2">Cub</option>
                  <option value="JM3">Sport</option>
                  <option value="JM4">Naked</option>
                  <option value="JM5">Offroad</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga" required />
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Persentase Laba [0 - 100]</label>
                <input type="number" name="persentase_laba" class="form-control" placeholder="Masukkan Persentase Laba" required />
              </div>
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Persentase Sparepart [100 - 500]</label>
                <input type="number" name="persentase_sparepart" class="form-control" placeholder="Masukkan Persentase Sparepart" required />
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" placeholder="Masukkan Stock" required />
              </div>
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Foto <b>[ .png ]</b></label>
                <input type="file" name="img_src" class="form-control" required />
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Deskripsi</label>
                <textarea class="form-control" name="description" rows="3" required></textarea>
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Tipe Mesin</label>
                <input type="text" name="tipe_mesin" class="form-control" placeholder="Masukkan Tipe Mesin" required />
              </div>
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Tipe Transmisi</label>
                <input type="text" name="tipe_transmisi" class="form-control" placeholder="Masukkan Tipe Transmisi" required />
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Volume Silinder</label>
                <input type="text" name="volume_silinder" class="form-control" placeholder="Masukkan Volume Silinder" required />
              </div>
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Kapasitas BBM</label>
                <input type="number" name="kapasitas_bbm" class="form-control" placeholder="Masukkan Kapasitas BBM" required />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="submit" name="submitTambahMotor" class="btn btn-primary">Tambah</button>
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

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

</body>

</html>