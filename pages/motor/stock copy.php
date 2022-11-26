<?php
include '../../config.php';

error_reporting(0);

session_start();


?>

<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Motor - Rooda</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/icon_favicon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <!-- <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span> -->
              <img src="../../assets/img/logo/logo_rooda.png" width="100">
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- NOTE : Dashboard -->
            <li class="menu-item">
              <a href="../dashboard/index.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

            <!-- NOTE : Persediaan Motor -->
            <li class="menu-item active open">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Persediaan Motor</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item active">
                  <a href="../motor/stock.html" class="menu-link">
                    <div data-i18n="Without navbar">Stock Motor</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="../motor/motor-masuk.html" class="menu-link">
                    <div data-i18n="Without navbar">Motor Masuk</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="../motor/motor-keluar.html" class="menu-link">
                    <div data-i18n="Without navbar">Motor Keluar</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!-- NOTE : Persediaan Sparepart -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Persediaan Part</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="../part/stock.html" class="menu-link">
                    <div data-i18n="Without navbar">Stock Sparepart</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="../part/part-masuk.html" class="menu-link">
                    <div data-i18n="Without navbar">Sparepart Masuk</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="../part/part-keluar.html" class="menu-link">
                    <div data-i18n="Without navbar">Sparepart Keluar</div>
                  </a>
                </li>
                
              </ul>
            </li>

            <!-- NOTE : Transaksi -->
            <li class="menu-item">
              <a href="../transaksi/transaksi.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Transaksi</div>
              </a>
            </li>

            <!-- NOTE : Karyawan -->
            <li class="menu-item">
              <a href="../karyawan/karyawan.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Karyawan</div>
              </a>
            </li>

            <!-- NOTE : Pelanggan -->
            <li class="menu-item">
              <a href="../pelanggan/pelanggan.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Pelanggan</div>
              </a>
            </li>

            <!-- NOTE : Supplier -->
            <li class="menu-item">
              <a href="../supplier/supplier.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Supplier</div>
              </a>
            </li>

            <!-- NOTE : Call Center -->
            <li class="menu-item">
              <a href="../callcenter/callcenter.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
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

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl container-p-y">
              <div class="row">
                <!-- <div class="col-lg-12 mb-4 order-0"> -->
                  
                  <!-- Hoverable Table rows -->
                  

                  <!-- responsive table -->
                  
              <div class="card">
                <h3 class="card-header">STOCK MOTOR</h3>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr class="text-nowrap">
                        <th></th>
                        <th>ID Motor</th>
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
                        $ambil_data_stock = mysqli_query($conn, 
                        "SELECT mt.id_motor, mt.nama, mr.nama_merk, jm.nama_jenis_motor, mt.harga, mt.stock,
                          sp.tipe_mesin, sp.volume_silinder, sp.tipe_transmisi, sp.kapasitas_bbm
                          FROM tb_motor mt
                          JOIN tb_merk mr
                          USING(id_merk)
                          JOIN tb_jenis_motor jm
                          USING(id_jenis_motor)
                          JOIN tb_spesifikasi sp
                          USING(id_motor)
                          ORDER BY mt.id_motor");

                        while($data = mysqli_fetch_array($ambil_data_stock)) {
                          $id_motor = $data['id_motor'];
                          $nama = $data['nama'];
                          $nama_merk = $data['nama_merk'];
                          $nama_jenis_motor = $data['nama_jenis_motor'];
                          $harga = $data['harga'];
                          $stock = $data['stock'];
                          $tipe_mesin = $data['tipe_mesin'];
                          $volume_silinder = $data['volume_silinder'];
                          $tipe_transmisi = $data['tipe_transmisi'];
                          $kapasitas_bbm = $data['kapasitas_bbm'];
                      ?>

                      <!-- <tr>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a>
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                          </div>
                        </td>
                        <td><b>MT0001</b></td>
                        <td>CBR150R</td>
                        <td>Honda</td>
                        <td>Sport</td>
                        <td>Rp48.000.000,00</td>
                        <td>12</td>
                        <td>SOHC</td>
                        <td>150CC</td>
                        <td>Manual</td>
                        <td>12.0 L</td>
                      </tr> -->
                      <tr>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a>
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-trash me-1"></i> Delete</a>
                            </div>
                          </div>
                        </td>
                        <td><b><?=$id_motor?></b></td>
                        <td><?=$nama?></td>
                        <td><?=$nama_merk?></td>
                        <td><?=$nama_jenis_motor?></td>
                        <td><?=$harga?></td>
                        <td><?=$stock?></td>
                        <td><?=$tipe_mesin?></td>
                        <td><?=$volume_silinder?></td>
                        <td><?=$tipe_transmisi?></td>
                        <td><?=$kapasitas_bbm?></td>
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

    <!-- NOTE : BUTTON ADD -->
    <div class="add">
       <a href="" type="button" class="btn btn-primary btn-add">
        <span class="tf-icons bx bx-plus"></span> Tambah
       </a>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

  </body>
</html>
