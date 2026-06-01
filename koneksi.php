<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "admin_cafe5cm";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>