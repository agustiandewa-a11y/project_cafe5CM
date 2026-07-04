<?php
include '../security.php';
include "../../koneksi.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

$query = mysqli_query($koneksi, "
    SELECT kategori.*, admin.username AS nama_admin 
    FROM kategori 
    LEFT JOIN admin ON kategori.admin_id = admin.admin_id
    ORDER BY kategori.kategori_id ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori - 5Cm Cafe</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="dm-layout-body">
    <div class="dm-sidebar-wrapper">
        <div class="dm-logo-text">5CM</div>
        <nav class="dm-navigation">
            <a href="../dashboard.php" class="dm-nav-item">Dashboard</a>
            <a href="../menu/index.php" class="dm-nav-item">Kelola Menu</a>
            <a href="index.php" class="dm-nav-item dm-item-active">Kelola Kategori</a>
            <a href="../galeri/index.php" class="dm-nav-item">Kelola Galeri</a>
            <a href="../reservasi/index.php" class="dm-nav-item">Kelola Reservasi</a>
        </nav>
    </div>

    <div class="dm-main-container">
        <div class="dm-top-navbar">
            <h1>Kelola Data Kategori</h1>
        </div>

        <div class="dm-content-page">
            <div class="dm-header-action">
                <h2>Data Kategori</h2>
                <a href="tambah.php" class="dm-btn-add"><span>➕</span> Tambah Kategori</a>
            </div>

            <div class="dm-card-table">
                <table class="dm-table-premium">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Kategori</th>
                            <th>Diubah Oleh</th>
                            <th style="text-align: center; width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <span class="dm-txt-name"><?= htmlspecialchars($data['nama_kategori']); ?></span>
                            </td>
                            <td>
                                
                                <span class="dm-txt-admin">
                                    <?= htmlspecialchars($data['nama_admin'] ?? 'Belum diketahui'); ?>
                                </span>
                            </td>
                            <td>
                                <div class="dm-btn-group">
                                    <a href="edit.php?id=<?= $data['kategori_id']; ?>" class="dm-action-link dm-lnk-edit">Edit</a>
                                    <a href="hapus.php?id=<?= $data['kategori_id']; ?>" 
                                    class="dm-action-link dm-lnk-delete"
                                    onclick="return confirm('Yakin hapus data?')">Hapus</a>
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