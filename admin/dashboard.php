<?php
session_start(); // 1. WAJIB di baris pertama untuk membaca data session

// 2. Proteksi Halaman: Cek apakah status session sudah "login"
if (!isset($_SESSION['status']) || $_SESSION['status'] !== "login") {
    // Jika belum login, tendang balik ke login.php di root
    header("Location: ../login.php?pesan=belum_login");
    exit;
}

// 3. Include koneksi jika dashboard membutuhkan data dari DB
include '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - 5Cm Cafe</title>
</head>
<body>

    <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Ini adalah halaman utama pengelolaan sistem Cafe 5Cm.</p>

    <hr>

    <nav>
        <ul>
            <li><a href="menu/tambah.php">Tambah Menu Baru</a></li>
            <li><a href="menu/data_menu.php">Kelola Semua Menu</a></li>
            <li><a href="../logout.php">Logout (Keluar)</a></li>
        </ul>
    </nav>

</body>
</html>