<?php

include "config.php";

//Function Format Rupiah
function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

//Format tanggal
function tanggal($tanggal)
{
    return date('d F Y', strtotime($tanggal));
}



//NOTE: Get Last Index of Table
function getLastIndex($conn, $table, $field)
{

    $query = 'SELECT MAX(?) AS last_index FROM ?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $field, $table);
    $stmt->execute();
    // $result = mysqli_query($conn, $sql);
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['last_index'];
    }
}

function getLastID($conn, $table, $field, $code)
{
    $sql = mysqli_query($conn, "SELECT max($field) as maxrow FROM $table");
    $data = mysqli_fetch_array($sql);
    $id = $data['maxrow'];
    $order = (int) substr($id, 4, 4);
    $order++;
    $code = $code;
    $id = $code . sprintf("%04s", $order);
    return $id;
}

function getLastUser($conn)
{
    $sql = mysqli_query($conn, "SELECT max(id) as maxrow FROM users");
    $data = mysqli_fetch_array($sql);
    $id = $data['maxrow'];
    $id++;
    return $id;
}

function createUsername($email)
{
    return preg_replace("/@gmail.com/", "", $email);
}









//NOTE : Data-data
function getTotalPenjualan($conn)
{
    $sql = "SELECT jumlah FROM 'tb_detail_transaksi'";
    // $result = mysqli_query($conn, $sql);
    // $length = $result->num_rows;
    // if($length > 0){
    //     $totalPenjualan = 0;

    //     for ($x = 0; $x <= $length; $x++) {
    //         $row = mysqli_fetch_assoc($result);
    //         $totalPenjualan =  $totalPenjualan + $row['jumlah'];
    //     }
    //     return $totalPenjualan;
    // }

    $sql = 'SELECT SUM(jumlah) AS jumlah FROM tb_detail_transaksi';
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['jumlah'];
    }
}

function getTotalPendapatan($conn)
{
    // $sql = 'SELECT COUNT(id_pelanggan) AS total_pelanggan FROM tb_pelanggan';
    // $result = mysqli_query($conn, $sql);
    // if($result->num_rows>0){
    //     $row = mysqli_fetch_assoc($result);
    //     return $row['total_pelanggan'];
    // }
}

function getTotalPelanggan($conn)
{
    $sql = 'SELECT COUNT(id_pelanggan) AS total_pelanggan FROM tb_pelanggan';
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_pelanggan'];
    }
}

function getTotalSupplier($conn)
{
    $sql = 'SELECT COUNT(id_supplier) AS total_supplier FROM tb_supplier';
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_supplier'];
    }
}

function getTotalMotor($conn)
{
    $sql = 'SELECT COUNT(id_motor) AS total_motor FROM tb_motor';
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_motor'];
    }
}

function getTotalKaryawan($conn)
{
    $sql = 'SELECT COUNT(id_karyawan) AS total_karyawan FROM tb_karyawan';
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_karyawan'];
    }
}




//GET MOTOR TERLARIS
function getIDMotorTerlaris($conn)
{
    $sql = 'SELECT id_motor, SUM(jumlah) AS terlaris
    FROM tb_detail_transaksi GROUP BY id_motor ORDER BY(terlaris) DESC LIMIT 1';

    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row; // ['id_motor', 'totalTerlaris']
    }
}

function getDataMotorTerlaris($conn, $idMotorTerlaris)
{
    $sql = "SELECT nama, img_src, description FROM tb_motor WHERE id_motor='$idMotorTerlaris'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result);
        return $data;
    }
}


//GET MOTOR TERBANYAK
function getDataStockMotorTerbanyak($conn)
{
    $sql = 'SELECT nama, stock, img_src FROM tb_motor ORDER BY(stock) DESC LIMIT 1';

    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row; // ['nama', 'stock', 'img_src']
    }
}
