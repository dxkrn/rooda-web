<?php
include 'config.php';
include 'functions.php';

error_reporting(0);

session_start();
if (!isset(($_SESSION['username']))) {
  header("Location:index");
  exit();
}
//Get ID from POST
$id_perbaikan = $_POST['id_perbaikan'];
$id_pelanggan = $_POST['id_pelanggan'];
$id_karyawan = $_POST['id_karyawan'];
$id_motor = $_POST['id_motor'];
$nama_pelanggan = $_POST['nama_pelanggan'];
$alamat_pelanggan = $_POST['alamat_pelanggan'];
$telp_pelanggan = $_POST['telp_pelanggan'];
$nama_karyawan = $_POST['nama_karyawan'];
$telp_karyawan = $_POST['telp_karyawan'];
$nama_motor = $_POST['nama_motor'];
$tgl_perbaikan = $_POST['tgl_perbaikan'];
$persentase_sparepart = $_POST['persentase_sparepart'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$subtotal_perbaikan = 0;


if (isset($_POST['submitHapusDetail'])) {
  $id_perbaikan = $_POST['id_perbaikan'];
  $id_jenis_perbaikan = $_POST['id_jenis_perbaikan'];
  $id_sparepart = $_POST['id_sparepart'];

  $hapusDetail = mysqli_query($conn, "DELETE FROM tb_detail_perbaikan WHERE id_perbaikan='$id_perbaikan' AND
  id_jenis_perbaikan='$id_jenis_perbaikan' AND id_sparepart='$id_sparepart'");

  if ($hapusDetail) {
    echo "<script>alert('Yeay, hapus detail berhasil!')</script>";
  } else {
    echo "<script>alert('Yeay, hapus detail gagal!')</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Invoice - Rooda</title>

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
  <link rel="stylesheet" href="assets/css/print.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />
  <script src="assets/vendor/js/helpers.js"></script>
  <script src="assets/js/config.js"></script>
  <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>


</head>

<body>
  <!-- Layout wrapper -->
  <div class="card">
    <div class="card-body">
      <div class="container mb-5 mt-3">
        <div class="row d-flex align-items-baseline">
          <div class="col-xl-9 mb-4">
            <img src="assets/img/logo/logo_rooda.png" width="100">
          </div>
          <div class="col-xl-9">
            <p style="color: #7e8d9f;font-size: 20px;">Perbaikan#<strong><?= $id_perbaikan ?></strong></p>
          </div>
          <hr>
        </div>

        <div class="container">
          <div class="col-md-12">
            <div class="text-center">
              <i class="fab fa-mdb fa-4x ms-0" style="color:#5d9fc5 ;"></i>
              <p class="pt-0"><b>Rooda</b> - <?= tanggal($tgl_perbaikan) ?></p>
            </div>

          </div>


          <div class="row">
            <div class="col-xl-8">
              <ul class="list-unstyled">
                <li class="text-muted">Pelanggan:</li>
                <li class="text-muted"><i class="fas fa-phone"></i><?= $nama_pelanggan ?></li>
                <li class="text-muted"><i class="fas fa-phone"></i><?= $alamat_pelanggan ?></li>
                <li class="text-muted"><i class="fas fa-phone"></i>0<?= $telp_pelanggan ?></li>
              </ul>
            </div>
            <div class="col-xl-4">
              <ul class="list-unstyled">
                <li class="text-muted">Mekanik:</li>
                <li class="text-muted"><i class="fas fa-phone"></i><?= $nama_karyawan ?></li>
                <li class="text-muted"><i class="fas fa-phone"></i>0<?= $telp_karyawan ?></li>
              </ul>
            </div>
          </div>

          <div class="row my-2 mx-1 justify-content-center">
            <table class="table table-striped table-borderless">
              <thead style="background-color:#4AD193 ;" class="text-white">
                <tr>
                  <th scope="col">Jenis Perbaikan</th>
                  <th scope="col">Sparepart</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Tarif</th>
                  <th scope="col">Total</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>

                <?php
                $ambil_data_detail = mysqli_query(
                  $conn,
                  "SELECT jp.nama_perbaikan, sp.nama_sparepart,  dp.id_jenis_perbaikan, dp.id_sparepart,
                  (jp.tarif + sp.harga) AS total_biaya, sp.harga AS harga_sparepart,
                  jp.tarif AS tarif_perbaikan
                FROM tb_detail_perbaikan dp
                JOIN tb_jenis_perbaikan jp
                USING(id_jenis_perbaikan)
                JOIN tb_sparepart sp
                USING(id_sparepart)
                WHERE id_perbaikan='$id_perbaikan'
                "
                );

                while ($data = mysqli_fetch_array($ambil_data_detail)) {
                  $id_jenis_perbaikan = $data['id_jenis_perbaikan'];
                  $id_sparepart = $data['id_sparepart'];
                  $nama_perbaikan = $data['nama_perbaikan'];
                  $nama_sparepart = $data['nama_sparepart'];
                  $harga_sparepart = $data['harga_sparepart'] * $persentase_sparepart / 100;
                  $tarif_perbaikan = $data['tarif_perbaikan'];
                  $total_biaya = $harga_sparepart + $tarif_perbaikan;
                  $subtotal_perbaikan = $subtotal_perbaikan + $total_biaya;
                ?>

                  <tr>
                    <td><?= $nama_perbaikan ?></td>
                    <td><?= $nama_sparepart ?></td>
                    <td><?= rupiah($harga_sparepart) ?></td>
                    <td><?= rupiah($tarif_perbaikan) ?></td>
                    <td><?= rupiah($total_biaya) ?></td>
                    <td class="noPrint">
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                          <input type="hidden" name="id_hapus" value="<?= $id_perbaikan; ?>">
                          <a class="dropdown-item" href="#hapusModal<?= $id_perbaikan;
                                                                    $id_jenis_perbaikan;
                                                                    $id_sparepart ?>" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $id_perbaikan;
                                                                                                                                        $id_jenis_perbaikan;
                                                                                                                                        $id_sparepart ?>"><i class="bx bx-trash me-1"></i> Delete</a>

                        </div>
                      </div>
                    </td>
                  </tr>

                  <!-- Modal Hapus -->
                  <div class="modal fade" id="hapusModal<?= $id_perbaikan;
                                                        $id_jenis_perbaikan;
                                                        $id_sparepart; ?>" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h3 class="modal-title" id="modalToggleLabel">Hapus Detail Perbaikan</h3>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form method="POST">
                          <div class="modal-body">
                            <input type="hidden" name="id_perbaikan" value="<?= $id_perbaikan; ?>">
                            <input type="hidden" name="id_jenis_perbaikan" value="<?= $id_jenis_perbaikan; ?>">
                            <input type="hidden" name="id_sparepart" value="<?= $id_sparepart; ?>">
                            <p>Yakin hapus detail dengan ID Perbaikan <?= $id_perbaikan ?> untuk <?= $nama_perbaikan ?> <?= $nama_sparepart ?></b></p>
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-primary d-grid w-100" type="submit" name="submitHapusDetail">Hapus</button>
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
          <hr>
          <div class="row d-flex flex-row-reverse bd-highlight">
            <div class="col-xl-4">
              <p class="text-black float-start"><span class="text-black me-3"> Total Biaya</span><span>
                  <h4><?= rupiah($subtotal_perbaikan) ?></h4>
                </span></p>
            </div>
          </div>
          <hr>
          <?php
          if ($username == preg_replace("/@gmail.com/", "", $email) and md5($username) == $password) {
            echo '<div class="row">';
            echo '<div class="col-md-2">';
            echo '<p>Email</p>';
            echo '</div>';
            echo '<div class="col-xl-10">';
            echo '<p>: ';
            echo $email;
            echo '</p>';
            echo '</div>';
            echo '</div>';

            echo '<div class="row">';
            echo '<div class="col-md-2">';
            echo '<p>Password</p>';
            echo '</div>';
            echo '<div class="col-xl-10">';
            echo '<p>: ';
            echo $username;
            echo '</p>';
            echo '</div>';
            echo '</div>';

            echo '<div class="row">';
            echo '<div class="col-xl-10">';
            echo '<p><b>*Segera login ke <u>www.rooda.tiwai.my.id</u> untuk mengubah Password</b></p>';
            echo '</div>';
            echo '</div>';
          }
          ?>

        </div>
      </div>
    </div>
  </div>
  <!-- / Layout wrapper -->

  <!-- NOTE : BUTTON ADD -->
  <div class="add">
    <!-- <a href="#tambahModal" data-bs-toggle="modal" data-bs-target="#tambahModal">Delete</a> -->

    <button onclick="window.print();" href="#" data-bs-toggle="modal" data-bs-target="#" type="button" class="btn btn-primary btn-add noPrint"> <span class="tf-icons bx bx-printer"></span> Cetak
    </button>
  </div>

  <!-- <script>
    window.print();
  </script> -->

  <script>
    $(document).ready(function() {
      $('#example').DataTable({
        // scrollX: true,
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