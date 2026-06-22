<?php
session_start(); 


if (!isset($_SESSION['status']) || $_SESSION['status'] !== "login") {
    
    header("Location: ../login.php?pesan=belum_login");
    exit;
}


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
            <li><a href="menu/index.php">Kelola Semua Menu</a></li>
            <li><a href="../logout.php">Logout (Keluar)</a></li>
        </ul>
    </nav>

</body>
</html>
