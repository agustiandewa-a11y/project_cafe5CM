<?php
session_start();
include "../../koneksi.php";

/* ==========================
   Cek Login Admin
========================== */
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

/* ==========================
   Ambil Data Galeri
========================== */
$query = mysqli_query($koneksi, "
    SELECT
        galeri.*,
        admin.username AS nama_admin
    FROM galeri
    LEFT JOIN admin
        ON galeri.admin_id = admin.admin_id
    ORDER BY gambar_id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Galeri - 5CM Cafe</title>

    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="dm-layout-body">

    <!-- ================= Sidebar ================= -->

    <div class="dm-sidebar-wrapper">

        <div class="dm-logo-text">
            5CM
        </div>

        <nav class="dm-navigation">

            <a href="../dashboard.php" class="dm-nav-item">
                Dashboard
            </a>

            <a href="../menu/index.php" class="dm-nav-item">
                Kelola Menu
            </a>

            <a href="../kategori/index.php" class="dm-nav-item">
                Kelola Kategori
            </a>

            <a href="index.php" class="dm-nav-item dm-item-active">
                Kelola Galeri
            </a>

            <a href="../../logout.php" class="dm-nav-item">
                Logout
            </a>

        </nav>

    </div>

    <!-- ================= Main ================= -->

    <div class="dm-main-container">

        <div class="dm-top-navbar">
            <h1>Kelola Galeri</h1>
        </div>

        <div class="dm-content-page">

            <div class="dm-header-action">

                <h2>Data Galeri</h2>

                <a href="tambah.php" class="dm-btn-add">
                    ➕ Tambah Foto
                </a>

            </div>

            <div class="dm-card-table">

                <table class="dm-table-premium">

                    <thead>

                        <tr>

                            <th style="width:70px;">No</th>

                            <th>Foto</th>

                            <th>Nama File</th>

                            <th>Diupload Oleh</th>

                            <th style="width:160px;text-align:center;">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $no = 1;

                    while($data = mysqli_fetch_assoc($query)){

                    ?>

                        <tr>

                            <td>
                                <?= $no++; ?>
                            </td>

                            <td>

                                <img
                                    src="../../Aset/<?= htmlspecialchars($data['nama_gambar']); ?>"
                                    class="dm-img-thumb"
                                    alt="Galeri">

                            </td>

                            <td>

                                <?= htmlspecialchars($data['nama_gambar']); ?>

                            </td>

                            <td>

                                <span class="dm-txt-admin">

                                    <?= htmlspecialchars($data['nama_admin']); ?>

                                </span>

                            </td>

                            <td>

                                <div class="dm-btn-group">

                                    <a
                                        href="hapus.php?id=<?= $data['gambar_id']; ?>"
                                        class="dm-action-link dm-lnk-delete"
                                        onclick="return confirm('Yakin ingin menghapus gambar ini?')">

                                        Hapus

                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>
</html>