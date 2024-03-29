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
  $sortBy = 'id_pelanggan';
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

//Menambah pelanggan Baru
if (isset($_POST['submitTambahData'])) {
  $id_pelanggan = getLastID($conn, 'tb_pelanggan', 'id_pelanggan', 'PG');
  $id_user = getLastUser($conn);
  $nama = $_POST['nama'];
  $username = createUsername($_POST['email']);
  $password = md5($username);
  $nik = $_POST['nik'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $email = $_POST['email'];
  $telp = $_POST['telp'];
  $tgl_lahir = $_POST['tgl_lahir'];
  $alamat = $_POST['alamat'];

  $insertUserQuery = "INSERT INTO users (id, name, email, password)
                      VALUES ('$id_user','$username','$email','$password')";

  $insertPelangganQuery = "INSERT INTO tb_pelanggan (id_pelanggan, id_user, nama, nik, jenis_kelamin, telp, tgl_lahir, alamat) 
                  VALUES ('$id_pelanggan', '$id_user' , '$nama', '$nik', '$jenis_kelamin', '$telp','$tgl_lahir', '$alamat')";

  $addUser = mysqli_query($conn, $insertUserQuery);
  if ($addUser) {
    $addPelanggan = mysqli_query($conn, $insertPelangganQuery);
    if ($addPelanggan) {
      header('refresh:0; url=pelanggan');
      echo "<script>alert('Yeay, Tambah pelanggan berhasil!')</script>";
    }
  } else {
    echo "<script>alert('Yahh :( Tambah pelanggan gagal!')</script>";
  }
}

// Edit pelanggan
if (isset($_POST['submitEditData'])) {
  $id_pelanggan = $_POST['id_pelanggan'];
  $nama = $_POST['nama'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $telp = $_POST['telp'];
  $tgl_lahir = $_POST['tgl_lahir'];
  $alamat = $_POST['alamat'];
  $nik = $_POST['nik'];

  $editQuery = "UPDATE tb_pelanggan SET nama='$nama', nik='$nik', jenis_kelamin='$jenis_kelamin', telp='$telp', tgl_lahir='$tgl_lahir', alamat='$alamat' WHERE id_pelanggan='$id_pelanggan'";

  $editData = mysqli_query($conn, $editQuery);
  if ($editData) {
    header('refresh:0; url=pelanggan');
    echo "<script>alert('Yeay, Edit Pelanggan berhasil!')</script>";
  } else {
    echo "<script>alert('Yahh :( Edit Pelanggan gagal!')</script>";
  }
}


//Hapus pelanggan

if (isset($_POST['submitHapus'])) {
  $id_pelanggan = $_POST['id_pelanggan'];

  $delData =  mysqli_query($conn, "DELETE FROM tb_pelanggan WHERE id_pelanggan='$id_pelanggan'");

  if ($delData) {
    echo "<script>alert('Yeay, Hapus Pelanggan berhasil!')</script>";
  } else {
    echo "<script>alert('Yahh :( Hapus Pelanggan gagal!')</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>pelanggan - Rooda</title>

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

  <!-- <link rel="stylesheet" href="assets/vendor/libs/datatables/dataTables.bootstrap5.css" /> -->

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="assets/vendor/js/helpers.js"></script>

  <script src="assets/js/config.js"></script>


  <!-- Datatable -->
  <!-- <link rel="stylesheet" href="assets/vendor/libs/datatables/dataTables.bootstrap5.css" /> -->
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"> -->
  <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script> -->
  <!-- <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script> -->

</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="dashboard" class="app-brand-link">
            <!-- <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span> -->
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
          <li class="menu-item">
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
          <li class="menu-item active">
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
                    <h3>Daftar Pelanggan</h3>
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
                            <option value="id_pelanggan">ID Motor Masuk</option>
                            <option value="nama">Nama</option>
                            <option value="name">Username</option>
                            <option value="nik">NIK</option>
                            <option value="jenis_kelamin">Jenis Kelamin</option>
                            <option value="email">Email</option>
                            <option value="telp">Telp</option>
                            <option value="tgl_lahir">Tanggal Lahir</option>
                            <option value="alamat">Alamat</option>
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
                  <table id="" class="table table-hover">
                    <thead>
                      <tr class="text-nowrap">
                        <th></th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>NIK</th>
                        <th>Jenis Kelamin</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
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

                      $ambil_data = mysqli_query(
                        $conn,
                        "SELECT *
                          FROM tb_pelanggan p
                          JOIN users u
                          WHERE p.id_user = u.id
                          HAVING p.id_pelanggan LIKE '%$searchValue%' OR p.nama LIKE '%$searchValue%'
                            OR p.nik LIKE '%$searchValue%' OR p.jenis_kelamin LIKE '%$searchValue%'
                            OR p.telp LIKE '%$searchValue%' OR p.tgl_lahir LIKE '%$searchValue%'
                            OR p.alamat LIKE '%$searchValue%' OR MONTHNAME(p.tgl_lahir) LIKE '%$searchValue%'
                            OR u.name LIKE '%$searchValue%' OR u.email LIKE '%$searchValue%'
                          ORDER BY $sortBy $sortType
                          LIMIT $limitValue
                          "
                      );

                      while ($data = mysqli_fetch_array($ambil_data)) {
                        $id_pelanggan = $data['id_pelanggan'];
                        $nama = $data['nama'];
                        $username = $data['name'];
                        $nik = $data['nik'];
                        $jenis_kelamin = $data['jenis_kelamin'];
                        $email = $data['email'];
                        $telp = $data['telp'];
                        $tgl_lahir = $data['tgl_lahir'];
                        $alamat = $data['alamat'];
                      ?>

                        <tr>
                          <td>
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">

                                <a class="dropdown-item" href="#editModal<?= $id_pelanggan; ?>" data-bs-toggle="modal" data-bs-target="#editModal<?= $id_pelanggan; ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                <input type="hidden" name="id_hapus" value="<?= $id_pelanggan; ?>">
                                <a class="dropdown-item" href="#hapusModal<?= $id_pelanggan; ?>" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $id_pelanggan; ?>"><i class="bx bx-trash me-1"></i> Delete</a>

                              </div>
                            </div>
                          </td>
                          <td><b><?= $id_pelanggan ?></b></td>
                          <td><?= $nama ?></td>
                          <td><?= $username ?></td>
                          <td><?= $nik ?></td>
                          <td><?= $jenis_kelamin ?></td>
                          <td><?= $email ?></td>
                          <td>0<?= $telp ?></td>
                          <td><?= tanggal($tgl_lahir) ?></td>
                          <td><?= $alamat ?></td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $id_pelanggan; ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <form method="POST">
                              <input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan ?>">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel3">Edit pelanggan</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Nama</label>
                                      <input type="text" name="nama" class="form-control" value="<?= $nama ?>" />
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">NIK</label>
                                      <input type="number" name="nik" class="form-control" value="<?= $nik ?>" />
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col mb-0">
                                      <label for="emailLarge" class="form-label">Jenis Kelamin</label>
                                      <select class="form-select" name="jenis_kelamin" aria-label="Default select example">
                                        <option selected value="<?= $jenis_kelamin ?>"><?= $jenis_kelamin ?></option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Email</label>
                                      <input type="email" name="email" class="form-control" value="<?= $email ?>" />
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Telepon</label>
                                      <input type="number" name="telp" class="form-control" value="<?= $telp ?>" />
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="html5-date-input" class="col-md-2 col-form-label">Tanggal Lahir</label>
                                      <input class="form-control" type="date" value="<?= $tgl_lahir ?>" name="tgl_lahir" />
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameLarge" class="form-label">Alamat</label>
                                      <textarea class="form-control" name="alamat" rows="3"><?= $alamat ?></textarea>
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

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapusModal<?= $id_pelanggan; ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h3 class="modal-title" id="modalToggleLabel">Hapus pelanggan</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>

                              <form method="POST">
                                <div class="modal-body">
                                  <input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan ?>">
                                  <p>Yakin hapus <b><?= $nama; ?></b> dengan ID <b><?= $id_pelanggan ?>?</b></p>
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
            <h5 class="modal-title" id="exampleModalLabel3">Tambah Pelanggan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Pelanggan" required />
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">NIK</label>
                <input type="number" name="nik" class="form-control" placeholder="Masukkan NIK" required />
              </div>
            </div>
            <div class="row">
              <div class="col mb-0">
                <label for="emailLarge" class="form-label">Jenis Kelamin</label>
                <select class="form-select" name="jenis_kelamin" aria-label="Default select example">
                  <option selected value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required />
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Telepon</label>
                <input type="number" name="telp" class="form-control" placeholder="Masukkan Telepon" required />
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="html5-date-input" class="col-md-2 col-form-label">Tanggal Lahir</label>
                <input class="form-control" type="date" value="2002-11-21" id="tgl_lahir" name="tgl_lahir" />
              </div>
            </div>
            <div class="row">
              <div class="col mb-3">
                <label for="nameLarge" class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="submit" name="submitTambahData" class="btn btn-primary">Tambah</button>
          </div>
        </div>
      </form>
    </div>
  </div>


  <script>
    $(document).ready(function() {
      $('#example').DataTable({
        scrollX: true,
      });
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

</body>

</html>