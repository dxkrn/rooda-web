<?php
//koneksi ke db

$server = "localhost";
$user = "root";
$pass = "";
$db = "rooda_try_data";

$conn = mysqli_connect($server, $user, $pass, $db);

if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}
