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
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="dashboard-page">

    <div class="sidebar">
        <h2>5CM</h2>
        <nav>
            <ul>
                <li><a href="menu/index.php">Kelola Semua Menu</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <h1>Dashboard</h1>
        </div>
</body>
</html>
