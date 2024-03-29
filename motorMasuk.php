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
  $sortBy = 'id_motor_masuk';
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
if (isset($_POST['submitTambahMotorMasuk'])) {

  $id_motor_masuk = getLastID($conn, 'tb_motor_masuk', 'id_motor_masuk', 'MM');
  $jumlah = $_POST['jumlah'];
  $id_motor = $_POST['id_motor'];
  $id_supplier = $_POST['id_supplier'];
  $id_karyawan = $_POST['id_karyawan'];
  $tgl_masuk = $_POST['tgl_masuk'];


  //Update Stock Motor
  $ambil_stock = mysqli_query($conn, "SELECT (stock + $jumlah) AS new_stock FROM tb_motor WHERE id_motor='$id_motor'");
  $row = mysqli_fetch_assoc($ambil_stock);
  $stock_baru = $row['new_stock'];

  $insertQuery = "INSERT INTO tb_motor_masuk (id_motor_masuk, id_motor, id_supplier, id_karyawan, jumlah, tgl_masuk) 
  VALUES ('$id_motor_masuk', '$id_motor', '$id_supplier', '$id_karyawan', '$jumlah', '$tgl_masuk')";

  $addData = mysqli_query($conn, $insertQuery);
  if ($addData) {
    $update_stock = mysqli_query($conn, "UPDATE tb_motor SET stock='$stock_baru' WHERE id_motor='$id_motor'");
    if ($update_stock) {
      header('refresh:0; url=motorMasuk');
      echo "<script>alert('Yeay, Tambah Motor Masuk berhasil!')</script>";
    }
  } else {
    echo "<script>alert('Yahh :( Tambah Motor Masuk gagal!')</script>";
    // header('location:stock.php');
  }
}

//Hapus  Motor Masuk
if (isset($_POST['submitHapus'])) {
  $id_motor_masuk = $_POST['id_motor_masuk'];
  $id_motor = $_POST['id_motor'];
  $jumlah = $_POST['jumlah'];

  //Update Stock Motor
  $ambil_stock = mysqli_query($conn, "SELECT (stock - $jumlah) AS new_stock FROM tb_motor WHERE id_motor='$id_motor'");
  $row = mysqli_fetch_assoc($ambil_stock);
  $stock_baru = $row['new_stock'];

  $delTableMotorMasuk =  mysqli_query($conn, "DELETE FROM tb_motor_masuk WHERE id_motor_masuk='$id_motor_masuk'");

  if ($delTableMotorMasuk) {
    $update_stock = mysqli_query($conn, "UPDATE tb_motor SET stock='$stock_baru' WHERE id_motor='$id_motor'");
    if ($update_stock) {
      echo "<script>alert('Yeay, Hapus Motor Masuk berhasil!')</script>";
    }
  } else {
    echo "<script>alert('Yahh :( Hapus Motor Masuk gagal!')</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Motor Masuk - Rooda</title>

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

  <!-- Datatable -->
  <!-- <link rel="stylesheet" href="assets/vendor/libs/datatables/dataTables.bootstrap5.css" /> -->
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"> -->
  <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> -->
  <!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script> -->

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
              <li class="menu-item">
                <a href="stockMotor" class="menu-link">
                  <div data-i18n="Without navbar">Stock Motor</div>
                </a>
              </li>
              <li class="menu-item active">
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
                    <h3>Motor Masuk</h3>
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
                            <option value="id_motor_masuk">ID Motor Masuk</option>
                            <option value="nama_motor">Nama Motor</option>
                            <option value="nama_supplier">Supplier</option>
                            <option value="nama_karyawan">Karyawan</option>
                            <option value="jumlah">Jumlah</option>
                            <option value="tgl_masuk">Tanggal</option>
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
                        <th>ID</th>
                        <th>Nama Motor</th>
                        <th>Supplier</th>
                        <th>Karyawan</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      if (isset($_POST['submitSort'])) {
                        $sortBy = $_POST['sort_by'];
                        $sortType = $_POST['sort_type'];
                        $limitValue = $_POST['limit_value'];
                        $selectedLimit = $_POST['limit_value'];
                        header('refresh:0; url=motorMasuk');
                      }

                      if (isset($_POST['submitSearch'])) {
                        $searchValue = $_POST['search_value'];
                        header('refresh:0; url=motorMasuk');
                      }

                      $ambil_data_stock = mysqli_query(
                        $conn,
                        "SELECT mm.id_motor_masuk, mm.jumlah, mm.tgl_masuk, mm.id_motor, mt.nama nama_motor, sr.nama nama_supplier, kr.nama nama_karyawan
                        FROM tb_motor_masuk mm
                        JOIN tb_motor mt
                        USING(id_motor)
                        JOIN tb_supplier sr
                        USING(id_supplier)
                        JOIN tb_karyawan kr
                        USING(id_karyawan)
                        WHERE mm.id_motor_masuk LIKE '%$searchValue%' OR mt.nama LIKE '%$searchValue%'
                          OR kr.nama LIKE '%$searchValue%' OR sr.nama LIKE '%$searchValue%'
                          OR mm.jumlah LIKE '%$searchValue%' OR mm.tgl_masuk LIKE '%$searchValue%'
                          OR MONTHNAME(mm.tgl_masuk) LIKE '%$searchValue%'
                        ORDER BY $sortBy $sortType
                        LIMIT $limitValue
                        "
                      );

                      while ($data = mysqli_fetch_array($ambil_data_stock)) {
                        $id_motor_masuk = $data['id_motor_masuk'];
                        $id_motor = $data['id_motor'];
                        $nama_motor = $data['nama_motor'];
                        $nama_karyawan = $data['nama_karyawan'];
                        $nama_supplier = $data['nama_supplier'];
                        $jumlah = $data['jumlah'];
                        $tgl_masuk = $data['tgl_masuk'];
                      ?>

                        <tr>
                          <td>
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">
                                <input type="hidden" name="id_motor_masuk" value="<?= $id_motor_masuk; ?>">
                                <a class="dropdown-item" href="#hapusModal<?= $id_motor_masuk; ?>" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $id_motor_masuk; ?>"><i class="bx bx-trash me-1"></i> Delete</a>
                              </div>
                            </div>
                          </td>
                          <td><b><?= $id_motor_masuk ?></b></td>
                          <td><?= $nama_motor ?></td>
                          <td><?= $nama_supplier ?></td>
                          <td><?= $nama_karyawan ?></td>
                          <td><?= $jumlah ?></td>
                          <td><?= tanggal($tgl_masuk) ?></td>
                        </tr>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal<?= $id_motor_masuk; ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h3 class="modal-title" id="modalToggleLabel">Hapus Motor Masuk</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>

                              <form method="POST">
                                <div class="modal-body">
                                  <input type="hidden" name="id_motor_masuk" value="<?= $id_motor_masuk ?>">
                                  <input type="hidden" name="id_motor" value="<?= $id_motor ?>">
                                  <input type="hidden" name="jumlah" value="<?= $jumlah ?>">
                                  <p>Yakin hapus <b><?= $nama_motor ?></b> dengan ID <b><?= $id_motor_masuk ?>?</b></p>
                                </div>
                                <div class="modal-footer">
                                  <button class="btn btn-primary d-grid w-100" type="submit" name="submitHapus">Hapus</button>
                                </div>
                              </form>
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
    <a href="#tambahModal" data-bs-toggle="modal" data-bs-target="#tambahModal" type="button" class="btn btn-primary btn-add"> <span class="tf-icons bx bx-plus"></span> Tambah
    </a>
  </div>

  <!-- Modal Tambah -->

  <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <form method="POST">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel3">Tambah Motor Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col mb-2">
                <label for="emailLarge" class="form-label">Nama Motor</label>
                <select class="form-select" name="id_motor" aria-label="Default select example">

                  <?php
                  $ambil_data_motor = mysqli_query(
                    $conn,
                    "SELECT nama, id_motor FROM tb_motor ORDER BY nama"
                  );

                  while ($data = mysqli_fetch_array($ambil_data_motor)) {
                    $nama_motor = $data['nama'];
                    $id_motor = $data['id_motor'];
                  ?>
                    <option value="<?= $id_motor ?>"><?= $nama_motor ?></option>
                  <?php
                  }
                  ?>

                </select>
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-2">
                <label for="emailLarge" class="form-label">Nama Supplier</label>
                <select class="form-select" name="id_supplier" aria-label="Default select example">

                  <?php
                  $ambil_data_supplier = mysqli_query(
                    $conn,
                    "SELECT nama, id_supplier FROM tb_supplier ORDER BY nama"
                  );

                  while ($data = mysqli_fetch_array($ambil_data_supplier)) {
                    $id_supplier = $data['id_supplier'];
                    $nama_supplier = $data['nama'];
                  ?>
                    <option value="<?= $id_supplier ?>"><?= $nama_supplier ?></option>
                  <?php
                  }
                  ?>

                </select>
              </div>
              <div class="col mb-2">
                <label for="emailLarge" class="form-label">Nama Karyawan</label>
                <select class="form-select" name="id_karyawan" aria-label="Default select example">

                  <?php
                  $ambil_data_karyawan = mysqli_query(
                    $conn,
                    "SELECT nama, id_karyawan FROM tb_karyawan WHERE posisi='Sales' ORDER BY nama"
                  );

                  while ($data = mysqli_fetch_array($ambil_data_karyawan)) {
                    $id_karyawan = $data['id_karyawan'];
                    $nama_karyawan = $data['nama'];
                  ?>
                    <option value="<?= $id_karyawan ?>"><?= $nama_karyawan ?></option>
                  <?php
                  }
                  ?>

                </select>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" placeholder="Masukkan Jumlah" required />
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="html5-date-input" class="col-md-2 col-form-label">Tanggal Masuk</label>
                <input class="form-control" type="date" value="2022-11-21" id="tgl_masuk" name="tgl_masuk" />
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="submit" name="submitTambahMotorMasuk" class="btn btn-primary">Tambah</button>
          </div>
        </div>
      </form>
    </div>
  </div>


  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });
  </script>


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

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

</body>

</html>